<template>
  <div class="conversation">
    <h1>{{ contact ? contact.name : 'Select a Contact' }}</h1>
    <MessagesFeed :contact="contact" :messages="messages" />
    <MessageComposer @send="sendMessage" />
  </div>
</template>

<script>
import MessagesFeed from "./MessagesFeed";
import MessageComposer from "./messageComposer";

export default {
  props: {
    contact: {
      type: Object,
      default: null
    },
    messages: {
      type: Array,
      default: []
    }
  },
  methods: {
    sendMessage(text) {
      if (!this.contact) {
        return;
      }

      axios
        .post("/conversation/send", {
          contact_id: this.contact.id,
          text: text
        })
        .then(response => {
          this.$emit("new", response.data);
        });
    }
  },
  components: {
    MessagesFeed,
    MessageComposer
  }
};
</script>