<template>
  <div class="contacts-list">
    <ul class="list-unstyled">
      <li
        class="media mt-2 mb-2"
        v-for="contact in sortedContacts"
        :key="contact.id"
        @click="selectContact(contact)"
        :class="{ 'selected': contact == selected }"
      >
        <span class="unread" v-if="contact.unread">{{ contact.unread }}</span>
        <img
          :src="getProfileImageFromPath(contact.profile_image)"
          class="align-self-center img-thumbnail mr-3"
          :alt="contact.name"
          width="100"
          height="100"
        />
        <div class="media-body p-2">
          <p>
            <span class="font-weight-bold">{{ contact.name }}</span>
            <br />
            {{ contact.email }}
            <br />
            {{ contact.phone }}
          </p>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    contacts: {
      type: Array,
      default: []
    }
  },
  data() {
    return {
      selected: this.contacts.length ? this.contacts[0] : null
    };
  },
  methods: {
    selectContact(contact) {
      this.selected = contact;

      this.$emit("selected", contact);
    },
    getProfileImageFromPath(image) {
      return "/storage/profiles/" + image;
    }
  },
  computed: {
    sortedContacts() {
      return _.sortBy(this.contacts, [
        contact => {
          if (contact == this.selected) {
            return Infinity;
          }
          return contact.unread;
        }
      ]).reverse();
    }
  }
};
</script>

<style lang="scss" scoped>
.contacts-list {
  max-height: 600px;
  overflow-y: scroll;
  overflow-x: hidden;
  -webkit-overflow-scrolling: touch;

  &::-webkit-scrollbar {
    display: none;
  }

  ul {
    li {
      &.selected {
        background: #dfdfdf;
      }
      &:hover {
        background: #dfdfdf;
        cursor: pointer;
      }
      span.unread {
        position: absolute;
        background: #eb5050;
        color: #fff;
        display: flex;
        font-weight: 700;
        min-width: 20px;
        justify-content: center;
        align-items: center;
        line-height: 20px;
        font-size: 12px;
        padding: 0 4px;
        border-radius: 3px;
      }
    }
  }
}
</style>