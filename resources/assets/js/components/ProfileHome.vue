<template>
    <div id="profile-home">
        <div class="container">
            <template v-if='loading_all'>
                <div class="row">
                    <div class="col-12">
                        <p class="text-center">
                            <i class="fas fa-spinner fa-spin fa-3x"></i>
                        </p>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="row">                 
                    <div class="col-md-4 order-last order-md-first">
                        <template v-if='contact || user'>
                            <div class="d-none d-md-block mb-3 pb-3">
                                <h6 class="h5 mb-3">CONTACT</h6>
                                <ul class="profile-contact-list list-unstyled">
                                    <template v-if='contact'>
                                        <template v-if='contact.email'>
                                            <li>
                                                <i class="far fa-envelope fa-lg"></i>
                                                <a :href="email_href">
                                                    {{ contact.email }}
                                                </a>
                                            </li>
                                        </template>
                                        <template v-if='contact.website'>
                                            <li>
                                                <i class="fas fa-globe-americas fa-lg"></i>
                                                <a :href="website_href" target="_blank">
                                                    {{ contact.website }}
                                                </a>
                                            </li>
                                        </template>
                                        <template v-if='contact.telephone'>
                                            <li>
                                                <i class="fas fa-phone fa-flip-horizontal fa-lg"></i>
                                                <a :href="telephone_href">
                                                    {{ contact.formatted_telephone }}
                                                </a>
                                            </li>
                                        </template>
                                        <template v-if='contact.location'>
                                            <li>
                                                <i class="fas fa-map-marker-alt fa-lg"></i>
                                                <a href="javascript:void(0);" data-target="modal" data-modal="#waldoMap" data-waldo-event-trigger="click">
                                                    {{ contact.location }}
                                                </a>
                                            </li>
                                        </template>
                                    </template>
                                    <template v-else-if='user'>
                                        <li>
                                            <i class="far fa-envelope fa-lg pr-2"></i>
                                            <a :href="email_href">
                                                {{ user.email }}
                                            </a>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>

                        <template v-if='degrees.length'>
                            <div class="mb-3 pb-3">
                                <h6 class="h5 mb-3">DEGREES</h6>
                                <ul class="profile-degrees-list list-unstyled">
                                    <template v-for='_degree in degrees'>
                                        <li>
                                            <strong>{{ _degree.degree }}</strong> {{ _degree.discipline }} {{ _degree.year }}, {{ _degree.institute }}
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>

                        
                        <div class="mb-3 pb-3 ">
                            <h6 class="h5 mb-3">INTERESTS</h6>
                            <template v-if='interests.length'>
                                <template v-for='_interest in interests'>
                                    <span class="badge badge-danger badge--profile-interests py-2 px-2 my-1 mr-1">
                                        {{ _interest.title }}
                                    </span>
                                </template>
                            </template>
                            <template v-else>
                                <span class="empty-state-msg">There are currently no interests to display.</span>
                            </template>
                        </div>
                    </div>

                    <div class="col-md-8 order-first order-md-last">
                        <template v-if='contact || user'>
                            <div class="d-block d-md-none mb-3 pb-3">
                                <h2 class="h5 mb-3 d-block d-md-none text-uppercase">Contact</h2>
                                <ul class="profile-contact-list list-unstyled">
                                    <template v-if='contact'>
                                        <template v-if='contact.email'>
                                            <li>
                                                <i class="far fa-envelope fa-lg"></i>
                                                <a :href="email_href">
                                                    {{ contact.email }}
                                                </a>
                                            </li>
                                        </template>
                                        <template v-if='contact.website'>
                                            <li>
                                                <i class="fas fa-globe-americas fa-lg"></i>
                                                <a :href="website_href" target="_blank">
                                                    {{ contact.website }}
                                                </a>
                                            </li>
                                        </template>
                                        <template v-if='contact.telephone'>
                                            <li>
                                                <i class="fas fa-phone fa-flip-horizontal fa-lg"></i>
                                                <a :href="telephone_href">
                                                    {{ contact.formatted_telephone }}
                                                </a>
                                            </li>
                                        </template>
                                        <template v-if='contact.location'>
                                            <li>
                                                <i class="fas fa-map-marker-alt fa-lg"></i>
                                                <a href="javascript:void(0);" data-target="modal" data-modal="#waldoMap" data-waldo-event-trigger="click">
                                                    {{ contact.location }}
                                                </a>
                                            </li>
                                        </template>
                                    </template>
                                    <template v-else-if='user'>
                                        <li>
                                            <i class="far fa-envelope fa-lg"></i>
                                            <a :href="email_href">
                                                {{ user.email }}
                                            </a>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>
                        
                        
                        <h2 class="h3 d-none d-md-block text-primary">Overview</h2>
                        <h2 class="h5 mb-3 d-block d-md-none text-uppercase">Overview</h2>
                    
                        <div class="mb-3 pb-3 mb-md-5 pb-md-4">
                            <template v-if='biography'>
                                {{ biography }}
                            </template>
                            <template v-else>
                                <span class="empty-state-msg">There is currently no overview information to display.</span>
                            </template>
                        </div>
                        

                        <template v-if='badges.length'>
                            <h2 class="h3 d-none d-md-block text-primary">Badges &amp; Awards</h2>
                            <h2 class="h5 mb-3 d-block d-md-none text-uppercase">Badges &amp; Awards</h2>

                            <div class="container">
                                <div class="row pt-2 pb-4">
                                    <template v-for='_badge in badges'>
                                        <div class="col-lg-4 col-12 pl-0">
                                             <div class="media">
                                                <div class="media-left pr-3 pb-3">
                                                    <img :src="_badge.url_image" class="media-object" style="width:60px">
                                                </div>
                                                <div class="media-body align-self-center">
                                                    <template v-if='_badge.url_web'>
                                                        <a :href="_badge.url_web" class="text-body">
                                                            {{ _badge.name }} <span v-if="_badge.award_date">({{ _badge.award_date }})</span>
                                                        </a>
                                                    </template>
                                                    <p v-else>{{ _badge.name }} <span v-if="_badge.award_date">({{ _badge.award_date }})</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div> 
                            </div>
                        </template>

                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
export default {
  name: 'ProfileHome',
  data() {
    return {
        user: null,
        contact: null,
        degrees: [],
        interests: [],
        biography: null,
        badges: [],
        loading_all: true
    }
  },
  computed: {
    email_href: function() {
        if(this.contact) {
            return "mailto:" + this.contact.email;
        }
        return "mailto:" + this.user.email;
    },
    telephone_href: function() {
        return "tel:" + this.contact.telephone;
    },
    website_href: function() {
        var myHttp = /^http/;
        if(myHttp.test(this.contact.website)) {
            return this.contact.website;
        }
        return 'http://' + this.contact.website;
    },
    person_uri: function() {
        return $("meta[name=person-uri]").attr('content');
    },
    person_email: function() {
        return $("meta[name=person-email]").attr('content');
    }
  },
  methods: {
    loadMetadata: function() {
        return axios.get(
            'people/' + this.person_uri,
            {
                baseURL: $('html').attr('data-api-url')
            }
        );
    },
    loadInterests: function() {
        return axios.get(
            'interests/personal',
            {
                baseURL: $("meta[name=affinity-url]").attr('content'),
                params: {
                    email: this.person_email
                }
            }
        );
    },
    loadBadges: function() {
        return axios.get(
            'badges',
            {
                baseURL: $("meta[name=affinity-url]").attr('content'),
                params: {
                    email: this.person_email
                }
            }
        );
    }
  },
  mounted() {
    // make the Axios calls concurrently and wait for all of them to return
    // before applying the reactive data
    axios.all([this.loadMetadata(), this.loadInterests(), this.loadBadges()])
        .then(axios.spread((metadata,interests,badges) => {
            // apply the profile metadata
            var person_data = metadata.data;
            this.user = person_data;
            if (person_data.primary_connection) {
                this.contact = person_data.primary_connection.pivot;
            } 
            
            this.degrees = person_data.degrees;
            this.biography = person_data.biography;

            // apply the interests
            var interest_data = interests.data;
            this.interests = interest_data.interests;

            // apply the badges
            var badges_data = badges.data;
            this.badges = badges_data.badges;

            // we have finished loading everything
            this.loading_all = false;
        }))
        .then(() => {
            // allow for the map to be used for location information
            Waldo.setAllWaldoListeners();
        });
  }
}
</script>