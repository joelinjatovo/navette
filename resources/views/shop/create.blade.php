@extends('layouts.customer')

@section('style')
<link href="/css/main/wizard-3.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="card card-custom">
    <div class="card-body p-0">
        <!--begin: Wizard-->
        <div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="first" data-wizard-clickable="true">
            <!--begin: Wizard Nav-->
            <div class="wizard-nav">
                <div class="wizard-steps px-8 py-8 px-lg-15 py-lg-3">
                    <!--begin::Wizard Step 1 Nav-->
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                        <div class="wizard-label">
                            <h3 class="wizard-title">
								<span>1.</span> Select Club
							</h3>
                            <div class="wizard-bar"></div>
                        </div>
                    </div>
                    <!--end::Wizard Step 1 Nav-->

                    <!--begin::Wizard Step 2 Nav-->
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                        <div class="wizard-label">
                            <h3 class="wizard-title">
								<span>2.</span> Enter Details
							</h3>
                            <div class="wizard-bar"></div>
                        </div>
                    </div>
                    <!--end::Wizard Step 2 Nav-->

                    <!--begin::Wizard Step 3 Nav-->
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                        <div class="wizard-label">
                            <h3 class="wizard-title">
								<span>3.</span> Select Services
							</h3>
                            <div class="wizard-bar"></div>
                        </div>
                    </div>
                    <!--end::Wizard Step 3 Nav-->

                    <!--begin::Wizard Step 4 Nav-->
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                        <div class="wizard-label">
                            <h3 class="wizard-title">
								<span>4.</span> Delivery Address
							</h3>
                            <div class="wizard-bar"></div>
                        </div>
                    </div>
                    <!--end::Wizard Step 4 Nav-->

                    <!--begin::Wizard Step 5 Nav-->
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                        <div class="wizard-label">
                            <h3 class="wizard-title">
								<span>5</span> Review and Submit
							</h3>
                            <div class="wizard-bar"></div>
                        </div>
                    </div>
                    <!--end::Wizard Step 5 Nav-->
                </div>
            </div>
            <!--end: Wizard Nav-->

            <!--begin: Wizard Body-->
            <div class="row justify-content-center py-10 px-8 py-lg-12 px-lg-10">
                <div class="col-xl-12 col-xxl-7">
                    <!--begin: Wizard Form-->
                    <form class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_form">
                        <!--begin: Wizard Step 1-->
                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                            <h4 class="mb-10 font-weight-bold text-dark">Choisissez le club</h4>
                            
                            <div class="col-xl-12">
                                <!--begin::Tiles Widget 22-->
                                <div class="card card-custom bgi-no-repeat gutter-b" style="height: 250px; background-color: #1B283F;)">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <h3 class="text-white font-weight-bolder">Create CRM Reports</h3>
                                        <p class="text-muted font-size-lg mt-5 mb-10">
                                            Outlines keep you and honest Indulging honest
                                        </p>
                                        <a href="#" class="btn btn-link btn-link-warning font-weight-bold">
                                            Create Report
                                            <span class="svg-icon svg-icon-lg svg-icon-warning"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/Navigation/Arrow-right.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                        <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"></rect>
                                                        <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "></path>
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                        </a>
                                    </div>
                                    <!--end::Body-->
                                    
                                </div>
                                <!--end::Tiles Widget 22-->

                                <!--begin::Item-->
                                <div class="d-flex flex-wrap align-items-center mb-6">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-50 symbol-2by3 flex-shrink-0 mr-4">
                                        <div class="symbol-label" style="background-image: url('/metronic/themes/metronic/theme/html/demo9/dist/assets/media/stock-600x400/img-17.jpg')"></div>
                                    </div>
                                    <!--end::Symbol-->

                                    <!--begin::Title-->
                                    <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 mr-2">
                                        <a href="#" class="text-dark font-weight-bold text-hover-primary mb-1 font-size-lg">BlueSky Apartments</a>
                                        <span class="text-muted font-weight-bold">2 bed, 1 bath, 1 carpark</span>
                                    </div>
                                    <!--end::Title-->

                                    <!--begin::Btn-->
                                    <button href="" class="btn btn-icon btn-light btn-sm">
                                        <span class="svg-icon svg-icon-success">
                                            <span class="svg-icon svg-icon-md"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/Navigation/Arrow-right.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                        <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"></rect>
                                                        <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "></path>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </button>
                                    <!--end::Btn-->
                                </div>
                                <!--end::Item-->
                            </div>
                        </div>
                        <!--end: Wizard Step 1-->

                        <!--begin: Wizard Step 2-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <h4 class="mb-10 font-weight-bold text-dark">Enter the Details of your Delivery</h4>
                            <!--begin::Input-->
                            <div class="form-group fv-plugins-icon-container">
                                <label>Package Details</label>
                                <input type="text" class="form-control" name="package" placeholder="Package Details" value="Complete Workstation (Monitor, Computer, Keyboard &amp; Mouse)">
                                <span class="form-text text-muted">Please enter your Pakcage Details.</span>
                            <div class="fv-plugins-message-container"></div></div>
                            <!--end::Input-->

                            <!--begin::Input-->
                            <div class="form-group fv-plugins-icon-container">
                                <label>Package Weight in KG</label>
                                <input type="text" class="form-control" name="weight" placeholder="Package Weight" value="25">
                                <span class="form-text text-muted">Please enter your Package Weight in KG.</span>
                            <div class="fv-plugins-message-container"></div></div>
                            <!--end::Input-->
                            <div class="form-text">Package Dimensions</div>
                            <div class="row">
                                <div class="col-xl-4">
                                    <!--begin::Input-->
                                    <div class="form-group fv-plugins-icon-container">
                                        <label>Package Width in CM</label>
                                        <input type="text" class="form-control" name="width" placeholder="Package Width" value="110">
                                        <span class="form-text text-muted">Please enter your Package Width in CM.</span>
                                    <div class="fv-plugins-message-container"></div></div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-4">
                                    <!--begin::Input-->
                                    <div class="form-group fv-plugins-icon-container">
                                        <label>Package Height in CM</label>
                                        <input type="text" class="form-control" name="height" placeholder="Package Height" value="90">
                                        <span class="form-text text-muted">Please enter your Package Height in CM.</span>
                                    <div class="fv-plugins-message-container"></div></div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-4">
                                    <!--begin::Input-->
                                    <div class="form-group fv-plugins-icon-container">
                                        <label>Package Length in CM</label>
                                        <input type="text" class="form-control" name="packagelength" placeholder="Package Length" value="150">
                                        <span class="form-text text-muted">Please enter your Package Length in CM.</span>
                                    <div class="fv-plugins-message-container"></div></div>
                                    <!--end::Input-->
                                </div>
                            </div>

                        </div>
                        <!--end: Wizard Step 2-->

                        <!--begin: Wizard Step 3-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <h4 class="mb-10 font-weight-bold text-dark">Select your Services</h4>
                            <!--begin::Select-->
                            <div class="form-group fv-plugins-icon-container">
                                <label>Delivery Type</label>
                                <select name="delivery" class="form-control">
                                    <option value="">Select a Service Type Option</option>
                                    <option value="overnight" selected="">Overnight Delivery (within 48 hours)</option>
                                    <option value="express">Express Delivery (within 5 working days)</option>
                                    <option value="basic">Basic Delivery (within 5 - 10 working days)</option>
                                </select>
                            <div class="fv-plugins-message-container"></div></div>
                            <!--end::Select-->

                            <!--begin::Select-->
                            <div class="form-group fv-plugins-icon-container">
                                <label>Packaging Type</label>
                                <select name="packaging" class="form-control">
                                    <option value="">Select a Packaging Type Option</option>
                                    <option value="regular" selected="">Regular Packaging</option>
                                    <option value="oversized">Oversized Packaging</option>
                                    <option value="fragile">Fragile Packaging</option>
                                    <option value="frozen">Frozen Packaging</option>
                                </select>
                            <div class="fv-plugins-message-container"></div></div>
                            <!--end::Select-->

                            <!--begin::Select-->
                            <div class="form-group fv-plugins-icon-container">
                                <label>Preferred Delivery Window</label>
                                <select name="preferreddelivery" class="form-control">
                                    <option value="">Select a Preferred Delivery Option</option>
                                    <option value="morning" selected="">Morning Delivery (8:00AM - 11:00AM)</option>
                                    <option value="afternoon">Afternoon Delivery (11:00AM - 3:00PM)</option>
                                    <option value="evening">Evening Delivery (3:00PM - 7:00PM)</option>
                                </select>
                            <div class="fv-plugins-message-container"></div></div>
                            <!--end::Select-->
                        </div>
                        <!--end: Wizard Step 3-->

                        <!--begin: Wizard Step 4-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <h4 class="mb-10 font-weight-bold text-dark">Setup Your Delivery Location</h4>
                            <div class="my-5">
                                <!--begin::Input-->
                                <div class="form-group fv-plugins-icon-container">
                                    <label>Address Line 1</label>
                                    <input type="text" class="form-control" name="locaddress1" placeholder="Address Line 1" value="Address Line 1">
                                    <span class="form-text text-muted">Please enter your Address.</span>
                                <div class="fv-plugins-message-container"></div></div>
                                <!--end::Input-->
                                
                                <!--begin::Input-->
                                <div class="form-group">
                                    <label>Address Line 2</label>
                                    <input type="text" class="form-control" name="locaddress2" placeholder="Address Line 2" value="Address Line 2">
                                    <span class="form-text text-muted">Please enter your Address.</span>
                                </div>
                                <!--end::Input-->
                                <div class="row">
                                    <div class="col-xl-6">
                                        <!--begin::Input-->
                                        <div class="form-group fv-plugins-icon-container">
                                            <label>Postcode</label>
                                            <input type="text" class="form-control" name="locpostcode" placeholder="Postcode" value="3072">
                                            <span class="form-text text-muted">Please enter your Postcode.</span>
                                        <div class="fv-plugins-message-container"></div></div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="col-xl-6">
                                        <!--begin::Input-->
                                        <div class="form-group fv-plugins-icon-container">
                                            <label>City</label>
                                            <input type="text" class="form-control" name="loccity" placeholder="City" value="Preston">
                                            <span class="form-text text-muted">Please enter your City.</span>
                                        <div class="fv-plugins-message-container"></div></div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <!--begin::Input-->
                                        <div class="form-group fv-plugins-icon-container">
                                            <label>State</label>
                                            <input type="text" class="form-control" name="locstate" placeholder="State" value="VIC">
                                            <span class="form-text text-muted">Please enter your State.</span>
                                        <div class="fv-plugins-message-container"></div></div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="col-xl-6">
                                        <!--begin::Select-->
                                        <div class="form-group fv-plugins-icon-container">
                                            <label>Country</label>
                                            <select name="loccountry" class="form-control">
                                                <option value="">Select</option>
                                                <option value="AF">Afghanistan</option>
                                                <option value="AX">Åland Islands</option>
                                                <option value="AL">Albania</option>
                                                <option value="DZ">Algeria</option>
                                                <option value="AS">American Samoa</option>
                                                <option value="AD">Andorra</option>
                                                <option value="AO">Angola</option>
                                                <option value="AI">Anguilla</option>
                                                <option value="AQ">Antarctica</option>
                                                <option value="AG">Antigua and Barbuda</option>
                                                <option value="AR">Argentina</option>
                                                <option value="AM">Armenia</option>
                                                <option value="AW">Aruba</option>
                                                <option value="AU" selected="">Australia</option>
                                                <option value="AT">Austria</option>
                                                <option value="AZ">Azerbaijan</option>
                                                <option value="BS">Bahamas</option>
                                                <option value="BH">Bahrain</option>
                                                <option value="BD">Bangladesh</option>
                                                <option value="BB">Barbados</option>
                                                <option value="BY">Belarus</option>
                                                <option value="BE">Belgium</option>
                                                <option value="BZ">Belize</option>
                                                <option value="BJ">Benin</option>
                                                <option value="BM">Bermuda</option>
                                                <option value="BT">Bhutan</option>
                                                <option value="BO">Bolivia, Plurinational State of</option>
                                                <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                                <option value="BA">Bosnia and Herzegovina</option>
                                                <option value="BW">Botswana</option>
                                                <option value="BV">Bouvet Island</option>
                                                <option value="BR">Brazil</option>
                                                <option value="IO">British Indian Ocean Territory</option>
                                                <option value="BN">Brunei Darussalam</option>
                                                <option value="BG">Bulgaria</option>
                                                <option value="BF">Burkina Faso</option>
                                                <option value="BI">Burundi</option>
                                                <option value="KH">Cambodia</option>
                                                <option value="CM">Cameroon</option>
                                                <option value="CA">Canada</option>
                                                <option value="CV">Cape Verde</option>
                                                <option value="KY">Cayman Islands</option>
                                                <option value="CF">Central African Republic</option>
                                                <option value="TD">Chad</option>
                                                <option value="CL">Chile</option>
                                                <option value="CN">China</option>
                                                <option value="CX">Christmas Island</option>
                                                <option value="CC">Cocos (Keeling) Islands</option>
                                                <option value="CO">Colombia</option>
                                                <option value="KM">Comoros</option>
                                                <option value="CG">Congo</option>
                                                <option value="CD">Congo, the Democratic Republic of the</option>
                                                <option value="CK">Cook Islands</option>
                                                <option value="CR">Costa Rica</option>
                                                <option value="CI">Côte d'Ivoire</option>
                                                <option value="HR">Croatia</option>
                                                <option value="CU">Cuba</option>
                                                <option value="CW">Curaçao</option>
                                                <option value="CY">Cyprus</option>
                                                <option value="CZ">Czech Republic</option>
                                                <option value="DK">Denmark</option>
                                                <option value="DJ">Djibouti</option>
                                                <option value="DM">Dominica</option>
                                                <option value="DO">Dominican Republic</option>
                                                <option value="EC">Ecuador</option>
                                                <option value="EG">Egypt</option>
                                                <option value="SV">El Salvador</option>
                                                <option value="GQ">Equatorial Guinea</option>
                                                <option value="ER">Eritrea</option>
                                                <option value="EE">Estonia</option>
                                                <option value="ET">Ethiopia</option>
                                                <option value="FK">Falkland Islands (Malvinas)</option>
                                                <option value="FO">Faroe Islands</option>
                                                <option value="FJ">Fiji</option>
                                                <option value="FI">Finland</option>
                                                <option value="FR">France</option>
                                                <option value="GF">French Guiana</option>
                                                <option value="PF">French Polynesia</option>
                                                <option value="TF">French Southern Territories</option>
                                                <option value="GA">Gabon</option>
                                                <option value="GM">Gambia</option>
                                                <option value="GE">Georgia</option>
                                                <option value="DE">Germany</option>
                                                <option value="GH">Ghana</option>
                                                <option value="GI">Gibraltar</option>
                                                <option value="GR">Greece</option>
                                                <option value="GL">Greenland</option>
                                                <option value="GD">Grenada</option>
                                                <option value="GP">Guadeloupe</option>
                                                <option value="GU">Guam</option>
                                                <option value="GT">Guatemala</option>
                                                <option value="GG">Guernsey</option>
                                                <option value="GN">Guinea</option>
                                                <option value="GW">Guinea-Bissau</option>
                                                <option value="GY">Guyana</option>
                                                <option value="HT">Haiti</option>
                                                <option value="HM">Heard Island and McDonald Islands</option>
                                                <option value="VA">Holy See (Vatican City State)</option>
                                                <option value="HN">Honduras</option>
                                                <option value="HK">Hong Kong</option>
                                                <option value="HU">Hungary</option>
                                                <option value="IS">Iceland</option>
                                                <option value="IN">India</option>
                                                <option value="ID">Indonesia</option>
                                                <option value="IR">Iran, Islamic Republic of</option>
                                                <option value="IQ">Iraq</option>
                                                <option value="IE">Ireland</option>
                                                <option value="IM">Isle of Man</option>
                                                <option value="IL">Israel</option>
                                                <option value="IT">Italy</option>
                                                <option value="JM">Jamaica</option>
                                                <option value="JP">Japan</option>
                                                <option value="JE">Jersey</option>
                                                <option value="JO">Jordan</option>
                                                <option value="KZ">Kazakhstan</option>
                                                <option value="KE">Kenya</option>
                                                <option value="KI">Kiribati</option>
                                                <option value="KP">Korea, Democratic People's Republic of</option>
                                                <option value="KR">Korea, Republic of</option>
                                                <option value="KW">Kuwait</option>
                                                <option value="KG">Kyrgyzstan</option>
                                                <option value="LA">Lao People's Democratic Republic</option>
                                                <option value="LV">Latvia</option>
                                                <option value="LB">Lebanon</option>
                                                <option value="LS">Lesotho</option>
                                                <option value="LR">Liberia</option>
                                                <option value="LY">Libya</option>
                                                <option value="LI">Liechtenstein</option>
                                                <option value="LT">Lithuania</option>
                                                <option value="LU">Luxembourg</option>
                                                <option value="MO">Macao</option>
                                                <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                                <option value="MG">Madagascar</option>
                                                <option value="MW">Malawi</option>
                                                <option value="MY">Malaysia</option>
                                                <option value="MV">Maldives</option>
                                                <option value="ML">Mali</option>
                                                <option value="MT">Malta</option>
                                                <option value="MH">Marshall Islands</option>
                                                <option value="MQ">Martinique</option>
                                                <option value="MR">Mauritania</option>
                                                <option value="MU">Mauritius</option>
                                                <option value="YT">Mayotte</option>
                                                <option value="MX">Mexico</option>
                                                <option value="FM">Micronesia, Federated States of</option>
                                                <option value="MD">Moldova, Republic of</option>
                                                <option value="MC">Monaco</option>
                                                <option value="MN">Mongolia</option>
                                                <option value="ME">Montenegro</option>
                                                <option value="MS">Montserrat</option>
                                                <option value="MA">Morocco</option>
                                                <option value="MZ">Mozambique</option>
                                                <option value="MM">Myanmar</option>
                                                <option value="NA">Namibia</option>
                                                <option value="NR">Nauru</option>
                                                <option value="NP">Nepal</option>
                                                <option value="NL">Netherlands</option>
                                                <option value="NC">New Caledonia</option>
                                                <option value="NZ">New Zealand</option>
                                                <option value="NI">Nicaragua</option>
                                                <option value="NE">Niger</option>
                                                <option value="NG">Nigeria</option>
                                                <option value="NU">Niue</option>
                                                <option value="NF">Norfolk Island</option>
                                                <option value="MP">Northern Mariana Islands</option>
                                                <option value="NO">Norway</option>
                                                <option value="OM">Oman</option>
                                                <option value="PK">Pakistan</option>
                                                <option value="PW">Palau</option>
                                                <option value="PS">Palestinian Territory, Occupied</option>
                                                <option value="PA">Panama</option>
                                                <option value="PG">Papua New Guinea</option>
                                                <option value="PY">Paraguay</option>
                                                <option value="PE">Peru</option>
                                                <option value="PH">Philippines</option>
                                                <option value="PN">Pitcairn</option>
                                                <option value="PL">Poland</option>
                                                <option value="PT">Portugal</option>
                                                <option value="PR">Puerto Rico</option>
                                                <option value="QA">Qatar</option>
                                                <option value="RE">Réunion</option>
                                                <option value="RO">Romania</option>
                                                <option value="RU">Russian Federation</option>
                                                <option value="RW">Rwanda</option>
                                                <option value="BL">Saint Barthélemy</option>
                                                <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                                <option value="KN">Saint Kitts and Nevis</option>
                                                <option value="LC">Saint Lucia</option>
                                                <option value="MF">Saint Martin (French part)</option>
                                                <option value="PM">Saint Pierre and Miquelon</option>
                                                <option value="VC">Saint Vincent and the Grenadines</option>
                                                <option value="WS">Samoa</option>
                                                <option value="SM">San Marino</option>
                                                <option value="ST">Sao Tome and Principe</option>
                                                <option value="SA">Saudi Arabia</option>
                                                <option value="SN">Senegal</option>
                                                <option value="RS">Serbia</option>
                                                <option value="SC">Seychelles</option>
                                                <option value="SL">Sierra Leone</option>
                                                <option value="SG">Singapore</option>
                                                <option value="SX">Sint Maarten (Dutch part)</option>
                                                <option value="SK">Slovakia</option>
                                                <option value="SI">Slovenia</option>
                                                <option value="SB">Solomon Islands</option>
                                                <option value="SO">Somalia</option>
                                                <option value="ZA">South Africa</option>
                                                <option value="GS">South Georgia and the South Sandwich Islands</option>
                                                <option value="SS">South Sudan</option>
                                                <option value="ES">Spain</option>
                                                <option value="LK">Sri Lanka</option>
                                                <option value="SD">Sudan</option>
                                                <option value="SR">Suriname</option>
                                                <option value="SJ">Svalbard and Jan Mayen</option>
                                                <option value="SZ">Swaziland</option>
                                                <option value="SE">Sweden</option>
                                                <option value="CH">Switzerland</option>
                                                <option value="SY">Syrian Arab Republic</option>
                                                <option value="TW">Taiwan, Province of China</option>
                                                <option value="TJ">Tajikistan</option>
                                                <option value="TZ">Tanzania, United Republic of</option>
                                                <option value="TH">Thailand</option>
                                                <option value="TL">Timor-Leste</option>
                                                <option value="TG">Togo</option>
                                                <option value="TK">Tokelau</option>
                                                <option value="TO">Tonga</option>
                                                <option value="TT">Trinidad and Tobago</option>
                                                <option value="TN">Tunisia</option>
                                                <option value="TR">Turkey</option>
                                                <option value="TM">Turkmenistan</option>
                                                <option value="TC">Turks and Caicos Islands</option>
                                                <option value="TV">Tuvalu</option>
                                                <option value="UG">Uganda</option>
                                                <option value="UA">Ukraine</option>
                                                <option value="AE">United Arab Emirates</option>
                                                <option value="GB">United Kingdom</option>
                                                <option value="US">United States</option>
                                                <option value="UM">United States Minor Outlying Islands</option>
                                                <option value="UY">Uruguay</option>
                                                <option value="UZ">Uzbekistan</option>
                                                <option value="VU">Vanuatu</option>
                                                <option value="VE">Venezuela, Bolivarian Republic of</option>
                                                <option value="VN">Viet Nam</option>
                                                <option value="VG">Virgin Islands, British</option>
                                                <option value="VI">Virgin Islands, U.S.</option>
                                                <option value="WF">Wallis and Futuna</option>
                                                <option value="EH">Western Sahara</option>
                                                <option value="YE">Yemen</option>
                                                <option value="ZM">Zambia</option>
                                                <option value="ZW">Zimbabwe</option>
                                            </select>
                                        <div class="fv-plugins-message-container"></div></div>
                                        <!--end::Select-->
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--end: Wizard Step 4-->

                        <!--begin: Wizard Step 5-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <!--begin::Section-->
                            <h4 class="mb-10 font-weight-bold text-dark">Review your Details and Submit</h4>
                            <h6 class="font-weight-bolder mb-3">
                                Current Address:
                            </h6>
                            <div class="text-dark-50 line-height-lg">
                                <div>Address Line 1</div>
                                <div>Address Line 2</div>
                                <div>Melbourne 3000, VIC, Australia</div>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <!--end::Section-->

                            <!--begin::Section-->
                            <h6 class="font-weight-bolder mb-3">
                                Delivery Details:
                            </h6>
                            <div class="text-dark-50 line-height-lg">
                                <div>Package: Complete Workstation (Monitor, Computer, Keyboard &amp; Mouse)</div>
                                <div>Weight: 25kg</div>
                                <div>Dimensions: 110cm (w) x 90cm (h) x 150cm (L)</div>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <!--end::Section-->

                            <!--begin::Section-->
                            <h6 class="font-weight-bolder mb-3">
                                Delivery Service Type:
                            </h6>
                            <div class="text-dark-50 line-height-lg">
                                <div>Overnight Delivery with Regular Packaging</div>
                                <div>Preferred Morning (8:00AM - 11:00AM) Delivery</div>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <!--end::Section-->

                            <!--begin::Section-->
                            <h6 class="font-weight-bolder mb-3">
                                Delivery Address:
                            </h6>
                            <div class="text-dark-50 line-height-lg">
                                <div>Address Line 1</div>
                                <div>Address Line 2</div>
                                <div>Preston 3072, VIC, Australia</div>
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end: Wizard Step 5-->

                        <!--begin: Wizard Actions-->
                        <div class="d-flex justify-content-between border-top mt-5 pt-10">
                            <div class="mr-2">
                                <button class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-prev">
                                    Previous
                                </button>
                            </div>
                            <div>
                                <button class="btn btn-success font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-submit">
                                    Submit
                                </button>
                                <button class="btn btn-primary font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-next">
                                    Next Step
                                </button>
                            </div>
                        </div>
                        <!--end: Wizard Actions-->
                    <div></div><div></div><div></div><div></div></form>
                    <!--end: Wizard Form-->
                </div>
            </div>
            <!--end: Wizard Body-->
        </div>
        <!--end: Wizard-->
    </div>
</div>
@endsection

@section('javascript')
<script src="/js/main/wizard-3.js"></script>
@endsection
