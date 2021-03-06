<?php

namespace App\Models;

use App\Events\Order\OrderActived;
use App\Events\Order\OrderCanceled;
use App\Events\Order\OrderCreated;
use App\Events\Order\OrderCompleted;
use App\Events\Order\OrderDeleted;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderPartialyCanceled;
use App\Events\Order\OrderPartialyCompleted;
use App\Events\Order\OrderPlaceChanged;
use App\Events\Order\OrderRefunded;
use App\Events\Order\OrderReceived;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    
    public const PAYMENT_TYPE_CASH = 'cash';
	
    public const PAYMENT_TYPE_CARD = 'card';
    
    public const PAYMENT_TYPE_STRIPE = 'stripe';
    
    public const PAYMENT_TYPE_PAYPAL = 'paypal';
    
    public const PAYMENT_TYPE_APPLE_PAY = 'apple_pay';
	
	
    public const PAYMENT_STATUS_SUCCEEDED = 'succeeded';
    
	public const PAYMENT_STATUS_PING = 'ping';
    
	public const PAYMENT_STATUS_AUTH_REQUIRED = 'auth-required';
    
	public const PAYMENT_STATUS_FAILED = 'failed';
	
	public const PAYMENT_STATUS_CANCELED = 'canceled';
	
	public const PAYMENT_STATUS_REFUNDED = 'refunded';
	
    
    
    public const STATUS_ACTIVE = 'active';
    
    public const STATUS_CANCELED = 'canceled';
    
    public const STATUS_COMPLETED = 'completed';
    
    public const STATUS_OK = 'ok';
    
    public const STATUS_ON_HOLD = 'on-hold';
	
    public const STATUS_PARTIALY_CANCELED = 'partialy-canceled';
	
    public const STATUS_PARTIALY_COMPLETED = 'partialy-completed';
	
    public const STATUS_PING = 'ping'; 
    
    public const STATUS_PROCESSING = 'processing';
	
    
    public const TYPE_GO = 'go';
    
    public const TYPE_BACK = 'back';
    
    public const TYPE_GO_BACK = 'go-back';
    
    public const TYPE_CUSTOM = 'custom';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'place',
        'privatized',
        'preordered',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'privatized' => 'boolean',
        'preordered' => 'boolean',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'actived' => OrderActived::class,
        'canceled' => OrderCanceled::class,
        'completed' => OrderCompleted::class,
        'created' => OrderCreated::class,
        'deleted' => OrderDeleted::class,
        'paid' => OrderPaid::class,
        'partialy-canceled' => OrderPartialyCanceled::class,
        'partialy-completed' => OrderPartialyCompleted::class,
        'place-changed' => OrderPlaceChanged::class,
        'received' => OrderReceived::class,
    ];
    
    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if( empty( $model->user_id ) && auth()->check() ) {
                $model->user_id = auth()->user()->id;
            }
        });
    }
    
    /**
     * Active order
     */
    public function active()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->save();
		
        $this->fireModelEvent('actived');
	}
    
    /**
     * Cancel order and set canceler user
     */
    public function cancel(User $user)
    {
        $this->status = self::STATUS_CANCELED;
        $this->canceled_at = now();
        $this->canceler_role = $user->isAdmin() ? Role::ADMIN : ( $user->isDriver() ? Role::DRIVER : Role::CUSTOMER );
        $this->canceler_id = $user->getKey();
        $this->save();
		
        $this->fireModelEvent('canceled');
    }
    
    /**
     * Get the user that canceled the order.
     */
    public function canceler()
    {
        return $this->belongsTo(User::class, 'canceler_id');
    }
    
    /**
     * Get the club that owns the order.
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
    
    /**
     * Complete order
     */
    public function complete()
    {
        $this->status = self::STATUS_COMPLETED;
        $this->completed_at = now();
        $this->save();
		
        $this->fireModelEvent('completed');
    }
    
    /**
     * Get the order items
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'order_id');
    }
    
    /**
     * Check if order is can be set as canceled
     */
    public function isCancelable()
    {
        switch($this->status){
            case self::STATUS_COMPLETED:
            case self::STATUS_CANCELED:
                return false;
            default:
                return true;
        }
    
        return true;
    }
    
    /**
     * Check if order is one car
     */
    public function isOneCar()
    {
		$max_place = 0;
		if($this->club){
			$max_place = $this->club->getMaxCarPlace();
		}
		
        return ($max_place >= $this->place);
    }
    
    /**
     * Check if order is can be refunded
     */
    public function isRefundable()
    {
        return ($this->payment_status == self::PAYMENT_STATUS_SUCCEEDED);
    }
    
    /**
     * Get the order's note.
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }
    
    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Set order as ok
     */
    public function ok()
    {
		$this->status = self::STATUS_OK;
		$this->save();
		
        $this->fireModelEvent('received');
    }
    
    /**
     * Set order as paid per the payment type (stripe, cash, etc)
	 *
	 * @param String $payment_type
     *
	 */
    public function paidPer($payment_type)
    {
        $this->payment_status = self::PAYMENT_STATUS_SUCCEEDED;
        $this->payment_type = $payment_type;
        $this->paid_at = now();
        $this->save();
        
        $items = $this->items()->where('items.status', Item::STATUS_PING)->get();
        foreach($items as $item){
            $item->ok();
        }
        
        $this->fireModelEvent('paid');
    }
    
    /**
     * Set order as partialy canceled
     */
    public function partialyCanceled()
    {
		$this->status = self::STATUS_PARTIALY_CANCELED;
		$this->save();
		
        $this->fireModelEvent('partialy-canceled');
    }
    
    /**
     * Set order as partialy completed
     */
    public function partialyCompleted()
    {
		$this->status = self::STATUS_PARTIALY_COMPLETED;
		$this->save();
		
        $this->fireModelEvent('partialy-completed');
    }
    
    /**
     * Get the payment tokens
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }
    
    /**
     * Update order reserved place
	 *
	 * @param String $place
     *
	 */
    public function updatePlace($place)
    {
        $this->place = $place;
        $this->save();
		
        $this->fireModelEvent('place-changed');
    }
    
    /**
     * Update order status
	 *
	 */
    public function updateStatus()
    {
		$ping_item = $this->items()->whereIn('items.status', [Item::STATUS_OK, Item::STATUS_ACTIVE])->exists();
		if($ping_item){
			$this->partialyCompleted();
		}else{
			$this->complete();
		}
    }
    
    /**
     * Set order as refund
	 *
	 * @param Float $value
     *
	 */
    public function refund($value)
    {
        $this->refund = $value;
        $this->payment_status = self::PAYMENT_STATUS_REFUNDED;
        $this->save();
		
        $this->fireModelEvent('refunded');
    }
    
    /**
     * Get zone that owns the order
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
    
    /**
     * Set VAT tax
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
        $this->total = $this->subtotal + $this->subtotal * $this->vat;
        
        return $this;
    }
    
    /**
     * Set zone and calculate
     */
    public function setZone(Zone $zone)
    {
        $this->zone_id = $zone->getKey();
		$this->currency = $zone->currency;
		$this->amount = $zone->price;
        if($this->privatized){
            $this->coefficient = 1.00;
            $this->amount = $zone->privatizedPrice;
        }elseif($this->preordered){
			// Reserver plus tard: amount * nombre de place du car
			if($this->car){
            	$this->coefficient = $this->car->place;
			}else{
            	$this->coefficient = $this->place;
			}
		}else{
			switch($this->type){
				case self::TYPE_GO:
				case self::TYPE_BACK:
					//Aller ou Retours : Diviser le montant par 2 (si place >= 2)
            		$this->coefficient = $this->place >= 2 ? $this->place / 2 : 1.5;
				break;
				default:
					//Aller et Retours : Montant * Nombre de place reserve
            		$this->coefficient = $this->place;
				break;
			}
		}
		
		// Ajouter le TVA
		$this->coefficient = round($this->coefficient, 2);
		$this->subtotal = $this->amount * $this->coefficient;
        $this->total = $this->subtotal + $this->subtotal * $this->vat;
        
        return $this;
    }
}
