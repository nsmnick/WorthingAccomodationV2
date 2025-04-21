<template>
  <div class="posts-search">
    <div class="posts-search__form">
      <ul class="filters">
        <li v-if="this.config.defaultCategoryID == 0">
          <span class="label">Location</span>
          <select
            id="locations"
            name="locations"
            data-size="5"
            class="filter-input"
            v-model="params.properties_location"
            @change="filterPosts()"
          >
            <option value="0">All locations</option>
            <option
              v-for="location in propertyLocations"
              :key="location.id"
              :value="location.id"
            >
              {{ location.name }}
            </option>
          </select>
        </li>
        <li class="no-drop" v-else>
          <span class="label">Location</span>
          <div>{{ this.defaultCategory }}</div>
        </li>

        <li>
          <span class="label">Property Type</span>
          <select
            id="types"
            name="types"
            data-size="5"
            class="filter-input"
            v-model="params.properties_type"
            @change="filterPosts()"
          >
            <option value="0">All types</option>
            <option
              v-for="type in propertyTypes"
              :key="type.id"
              :value="type.id"
            >
              <span>{{ type.name }}</span>
            </option>
          </select>
        </li>
        <li>
          <span class="label">No of Guests</span>
          <select
            id="maximum-guests"
            name="maximum_guests"
            class="filter-input"
            v-model="params.properties_guests"
            @change="filterPosts()"
          >
            <option value="0">Any</option>
            <option
              v-for="guests in propertyGuests"
              :key="guests.id"
              :value="guests.value"
            >
              {{ guests.name }}
            </option>
          </select>
        </li>
      </ul>

      <button class="reset-button" :disabled="loading" @click="clear">
        Reset
      </button>
    </div>

    <div v-if="total == 0 && !loading" class="posts-search__no-results">
      Sorry, there are no properties that match the above criteria.
    </div>

    <TransitionGroup
      name="stagged-fade"
      tag="div"
      class="posts-search__results"
    >
      <template v-for="(post, index) in posts" :key="index">
        <div class="posts-search__post">
          <div class="property-container">
            <div class="property-container__col1">
              <div class="image-container">
                <img
                  v-if="post.customFields.featured_image_src"
                  :src="post.customFields.featured_image_src"
                  :srcset="post.customFields.featured_image_srcset"
                  sizes="(max-width: 480px) 100vw, 50vw"
                  :alt="post.customFields.featured_image_alt"
                  loading="lazy"
                />
              </div>
            </div>
            <div class="property-container__col2">
              <a class="" :href="post.customFields.post_link">
                <h2 v-html="post.title"></h2
              ></a>

              <p v-html="post.excerpt"></p>

              <a class="button" :href="post.customFields.post_link"
                >Find out more</a
              >
            </div>
          </div>
        </div>
      </template>
    </TransitionGroup>

    <div v-if="loading" class="posts-search__loading-spinner"></div>

    <div v-if="!loading && showMore" class="posts-search__load-more">
      <div @click="getMorePosts" class="button button--fixed-width">
        Load more
      </div>
    </div>
  </div>
</template>

<script>
import searchConfig from "../configs/property-search-form-config.json";

export default {
  props: {
    config: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  data() {
    return {
      posts: [],
      propertyLocations: [],
      propertyTypes: [],
      propertyGuests: searchConfig.maximum_guests,
      params: {
        properties_location: "0",
        properties_type: "0",
        properties_guests: "0",
        page: 1,
        per_page: 20,
        orderby: "menu_order",
        order: "asc",
      },
      keywords: "",
      selectedLocations: "0",
      selectedTypes: "0",
      selectedGuests: "0",
      defaultCategory: "",
      loading: false,
      total: 0,
      totalPages: 0,
      staggerDelay: 50,
    };
  },
  mounted() {
    if (this.config.defaultCategory) {
      this.defaultCategory = this.config.defaultCategory;
    }

    if (this.config.defaultCategoryID) {
      if (this.isNumeric(this.config.defaultCategoryID)) {
        this.selectedLocations = this.config.defaultCategoryID;
      }
      if (this.selectedLocations !== 0) {
        this.params.properties_location = this.selectedLocations;
      } else {
        delete this.params.properties_location;
      }
    }

    this.getLocations();
    this.getTypes();
    this.getPosts();
  },
  computed: {
    showMore() {
      return this.params.page < this.totalPages || this.loading;
    },
  },
  methods: {
    isNumeric: function (n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    },
    async getLocations() {
      this.loading = true;

      await this.axios
        .get("properties_location", { perPage: -1 })
        .then((response) => {
          this.propertyLocations = response.data;
        });

      this.loading = false;
    },
    async getTypes() {
      this.loading = true;

      await this.axios
        .get("properties_type", { perPage: -1 })
        .then((response) => {
          this.propertyTypes = response.data;
        });

      this.loading = false;
    },
    async getPosts() {
      this.loading = true;

      const params = { ...this.params };
      //console.log(params);

      if (params.properties_location === "0") {
        delete params.properties_location;
      }

      if (params.properties_type === "0") {
        delete params.properties_type;
      }
      if (params.properties_guests === "0") {
        delete params.properties_guests;
      }

      await this.axios
        .get("properties", {
          params,
        })
        .then((response) => {
          const posts = [];

          response.data.forEach((post) => {
            posts.push({
              title: post.title.rendered,
              excerpt: post.excerpt.rendered,
              date: post.formatted_date,
              customFields: post.custom_fields,
            });
          });
          this.posts = this.posts.concat(posts);
          this.total = parseInt(response.headers["x-wp-total"], 10);
          this.totalPages = parseInt(response.headers["x-wp-totalpages"], 10);
        });

      //animationsV2();
      this.loading = false;
    },
    async getMorePosts() {
      this.params.page += 1;
      this.loading = true;

      const params = { ...this.params };

      if (params.properties_location === "0") {
        delete params.properties_location;
      }

      if (params.properties_type === "0") {
        delete params.properties_type;
      }
      if (params.properties_guests === "0") {
        delete params.properties_guests;
      }

      await this.axios
        .get("properties", {
          params,
        })
        .then((response) => {
          const morePosts = [];

          response.data.forEach((post) => {
            morePosts.push({
              link: post.link,
              title: post.title.rendered,
              excerpt: post.excerpt.rendered,
              date: post.formatted_date,
              customFields: post.custom_fields,
            });
          });
          this.posts = this.posts.concat(morePosts);
        });

      this.loading = false;
    },
    filterPosts() {
      this.posts = [];
      this.params.page = 1;
      this.getPosts();
    },
    filterPaginationPosts() {
      this.posts = [];
      this.getPosts();
    },
    clear() {
      this.params.properties_location = "0";
      this.params.properties_type = "0";
      this.params.properties_guests = "0";
      this.posts = [];
      this.params.page = 1;
      delete this.params.offset;
      this.getPosts();
    },
    beforeEnter(el) {
      el.style.opacity = 0;
    },
    onEnter(el) {
      const delay = el.dataset.index * this.staggerDelay;
      setTimeout(() => {
        el.style.opacity = 1;
      }, delay);
    },
    onLeave(el) {
      el.style.display = "none";
    },
    paginationCallback(pageNumber) {
      this.params.page = pageNumber;
      // history.pushState(
      //   this.params.page,
      //   'null',
      //   window.location.pathname + '?pl=' + this.params.page,
      // );

      // // Jump to search results.
      // let top = document.getElementById('results-top').offsetTop;
      // window.scrollTo(0, top - 300);

      this.filterPaginationPosts();
    },
  },
};
</script>
