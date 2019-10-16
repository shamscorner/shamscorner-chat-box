<template>
  <div class="feed">
    <ul v-if="contact" ref="feed">
      <li
        v-for="message in messages"
        :class="`message${message.to == contact.id ? ' sent' : ' received'}`"
        :key="message.id"
      >
        <div class="text">{{ message.text }}</div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    contact: {
      type: Object
    },
    messages: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      message: ""
    };
  },
  methods: {
    send() {
      if (this.message == "") {
        return;
      }

      this.$emit("send", this.message);
      this.message = "";
    },
    scrollToBottom() {
      setTimeout(() => {
        this.$refs.feed.scrollTop =
          this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
      }, 50);
    }
  },
  watch: {
    contact(contact) {
      this.scrollToBottom();
    },
    messages(messages) {
      this.scrollToBottom();
    }
  }
};
</script>

<style lang="scss" scoped>
.feed {
  min-height: 200px;
}
ul {
  max-height: 472px;
  list-style-type: none;
  padding: 5px;
  overflow-y: scroll;
  overflow-x: hidden;

  &::-webkit-scrollbar {
    display: none;
  }

  li {
    &.message {
      margin: 10px 0;
      width: 100%;

      .text {
        max-width: 200px;
        border-radius: 5px;
        padding: 12px;
        display: inline-block;
      }

      &.received {
        text-align: right;

        .text {
          text-align: left;
          background: #acd5f3;
        }
      }

      &.sent {
        text-align: left;

        .text {
          background: #a3f3c5;
        }
      }
    }
  }
}
@media only screen and (min-width: 574px) {
  .feed {
    height: 74%;
  }
}
@media only screen and (min-width: 768px) {
  .feed {
    height: 81%;
  }
}
</style>