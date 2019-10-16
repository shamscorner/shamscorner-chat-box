<template>
  <div class="container chat-app">
    <div class="row">
      <Conversation
        class="col-sm-6 col-lg-8"
        :contact="selectedContact"
        :messages="messages"
        @new="saveNewMessage"
      />
      <ContactList
        class="col-sm-6 col-lg-4"
        :contacts="contacts"
        @selected="startConversationWith"
      />
    </div>
  </div>
</template>

<script>
import Conversation from "./Conversation";
import ContactList from "./ContactList";

export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      selectedContact: null,
      messages: [],
      contacts: []
    };
  },
  mounted() {
    Echo.private(`messages.${this.user.id}`).listen("NewMessage", e => {
      this.handleIncoming(e.message);
    });
    //console.log(this.user);
    axios.get("/contacts").then(response => {
      //console.log(response.data);
      this.contacts = response.data;
    });
  },
  methods: {
    startConversationWith(contact) {
      this.updateUnreadContact(contact, true);

      axios.get(`/conversation/${contact.id}`).then(response => {
        this.messages = response.data;
        this.selectedContact = contact;
      });
    },
    saveNewMessage(message) {
      this.messages.push(message);
    },
    handleIncoming(message) {
      if (this.selectedContact && message.from == this.selectedContact.id) {
        this.saveNewMessage(message);
        return;
      }

      this.updateUnreadContact(message.from_contact, false);
    },
    updateUnreadContact(contact, reset) {
      this.contacts = this.contacts.map(single => {
        if (single.id != contact.id) {
          return single;
        }

        if (reset) {
          single.unread = 0;
        } else {
          single.unread += 1;
        }

        return single;
      });
    }
  },
  components: {
    Conversation,
    ContactList
  }
};
</script>
