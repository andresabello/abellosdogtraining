<template>
  <div class="tabbed-content">
    <ul class="nav nav-tabs">
      <li class="nav-item" v-for="(tab, index) in tabs">
        <a class="nav-link text-danger" :class="{'active': index === currentTabIndex}" :href="'#' + currentTabIndex"
           @click="setCurrentTab(index)">{{ tab.title }}</a>
      </li>
    </ul>
    <div class="row" v-for="(tab, index) in tabs" v-if="index === currentTabIndex">
      <div class="col-lg-6">
        <img :src="tab.image" :alt="tab.title" class="img-fluid" v-lazy="tab.image" :srcset="tab.imageSrcset">
      </div>
      <div class="col-lg-5 ml-lg-5">
        <div class="content" v-html="tab.text"></div>
        <div class="tab-section-cta mt-2 text-center text-lg-left">
          <a :href="tab.url" class="btn btn-secondary" v-if="tab.button_text && tab.button_text.length > 2 ">
            {{ tab.button_text }} </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'tabbed-content',
  props: {
    tabs: {
      type: Array,
      default() {
        return []
      },
    },
  },
  data() {
    return {
      currentTabIndex: 0,
    }
  },
  methods: {
    setCurrentTab(index) {
      this.currentTabIndex = index
    },
  },
}
</script>

<style scoped lang="scss">
@import "../../scss/variables";

.title-bar {
  border-bottom: 3px solid $white;

  .col {

    &:last-of-type {
      border-right: 0;
    }
  }

  .title-wrapper {
    padding: 21px 20px;
    text-align: center;
    color: $white;
    transition: all .2s ease-in-out;
    cursor: pointer;
    border: 1px solid #111;
    background-color: lighten($dark, 10);

    &.active, &:hover {
      background-color: $white;
      color: $dark;
      border-bottom: 2px solid $primary;
      padding: 20px;
    }
  }
}
</style>