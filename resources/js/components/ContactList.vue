<template>
  <div class="contacts-list">
    <ul class="list-unstyled">
      <li class="media" v-for="contact in contacts" :key="contact.id">
        <img
          :src="contact.profile_image"
          class="align-self-center img-thumbnail mr-3"
          :alt="contact.name"
        />
        <div class="media-body">
          <h5 class="mt-0">{{ contact.name }}</h5>
          <p class="mb-0">{{ contact.email }}</p>
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
  }
};
</script>