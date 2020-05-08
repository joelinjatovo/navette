<template
  <a class="dropdown-item" href="#">{{notification.data}} <span class="date">{{created_at}}</span></a>
</template>

<script>
  export default {
    name: "AppNotification",
    props: ['notification'],
    computed: {
      created_at() {
        return moment(this.notification.created_at).format('MMMM Do YYYY')
      },
      avatar() {
        return `https://api.adorable.io/avatars/48/${this.comment.author}@adorable.io.png`
      }
    }
  }
</script>

<style lang="scss" scoped>
  .notification-wrapper {
    list-style: none;
    text-align: left;
    overflow: hidden;
    margin-bottom: 2em;
    padding: .4em;

    .profile {
      width: 80px;
      float: left;
    }

    .msg-body {
      padding: .8em;
      color: #666;
      line-height: 1.5;
    }

    .msg {
      width: 86%;
      float: left;
      background-color: #fff;
      border-radius: 0 5px 5px 5px;
      position: relative;
      &::after {
        content: " ";
        position: absolute;
        left: -13px;
        top: 0;
        border: 14px solid transparent;
        border-top-color: #fff;
      }
    }

    .date {
      float: right;
    }
    .name {
      margin: 0;
      color: #999;
      font-weight: 700;
      font-size: .8em;
    }

    p:last-child {
      margin-top: .6em;
      margin-bottom: 0;
    }

  }
</style>