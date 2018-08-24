<template>
    <div id="home">
        <div class="container pt-4">
            <div class="row">                 
                <div class="col-md-4">
                    
                    <div class="FAC-contact FACborder-line-wrapper">
                        <h6>CONTACT</h6>
                        <ul>
                            <template v-if='contact'>
                                <template v-if='contact.email'>
                                    <li>
                                        <i class="far fa-envelope fa-lg pr-2"></i>
                                        <a :href="email_href">
                                            {{ contact.email }}
                                        </a>
                                    </li>
                                </template>
                                <template v-if='contact.website'>
                                    <li>
                                        <i class="fas fa-globe-americas fa-lg pr-2"></i>
                                        <a :href="contact.website" target="_blank">
                                            {{ contact.website }}
                                        </a>
                                    </li>
                                </template>
                                <template v-if='contact.telephone'>
                                    <li>
                                        <i class="fas fa-phone fa-lg pl-2"></i>
                                        <a :href="telephone_href">
                                            {{ contact.formatted_telephone }}
                                        </a>
                                    </li>
                                </template>
                                <template v-if='contact.location'>
                                    <li>
                                        <i class="fas fa-map-marker-alt fa-lg px-1"></i>
                                        <a href="#">
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

                    <template v-if='degrees.length'>
                        <div class="FAC-degrees FACborder-line-wrapper">
                            <h6>DEGREES</h6>
                            <ul class="timeline">
                                <template v-for='_degree in degrees'>
                                    <li class="timeline__header pb-3">
                                        <strong>{{ _degree.degree }}</strong> {{ _degree.discipline }} {{ _degree.year }}, {{ _degree.institute }}
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>

                    <template v-if='interests.length'>
                        <div class="FAC-interests FACborder-line-wrapper ">
                            <h6>INTERESTS</h6>
                            <template v-for='_interest in interests'>
                                <a class="badge badge-primary py-2 px-2 my-1" href="#">
                                    {{ _interest.title }}
                                </a>
                            </template>
                        </div>
                    </template>
                </div>

                <div class="col-md-8 pr-3">
                    <template v-if='contact'>
                        <div class="FAC-contact-sm FACborder-line-wrapper">
                            <h6>CONTACT</h6>
                            <ul>
                                <template v-if='contact.email'>
                                    <li>
                                        <i class="far fa-envelope fa-lg pr-2"></i>
                                        <a :href="email_href">
                                            {{ contact.email }}
                                        </a>
                                    </li>
                                </template>
                                <template v-if='contact.website'>
                                    <li>
                                        <i class="fas fa-globe-americas fa-lg pr-2"></i>
                                        <a :href="contact.website" target="_blank">
                                            {{ contact.website }}
                                        </a>
                                    </li>
                                </template>
                                <template v-if='contact.telephone'>
                                    <li>
                                        <i class="fas fa-phone fa-lg pl-2"></i>
                                        <a :href="telephone_href">
                                            {{ contact.formatted_telephone }}
                                        </a>
                                    </li>
                                </template>
                                <template v-if='contact.location'>
                                    <li>
                                        <i class="fas fa-map-marker-alt fa-lg px-1"></i>
                                        <a href="#">
                                            {{ contact.location }}
                                        </a>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>
                    
                    <template v-if='biography'>
                        <h2>Overview</h2>
                        <div class="FAC-Overview__content">
                            {{ biography }}
                        </div>
                    </template>

                    <template v-if='badges.length'>
                        <h2>Badges & Awards</h2>
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
                                                    <a :href="_badge.url_web">
                                                        <p>{{ _badge.name }} ({{ _badge.award_date }})</p>
                                                    </a>
                                                </template>
                                                <p v-else>{{ _badge.name }} ({{ _badge.award_date }})</p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div> 
                        </div>
                    </template>

                    <template v-if='degrees.length'>
                        <div class="FAC-degrees-sm FACborder-line-wrapper">
                            <h6>DEGREES</h6>
                            <ul class="timeline">
                                <template v-for='_degree in degrees'>
                                    <li class="timeline__header pb-3">
                                        <strong>{{ _degree.degree }}</strong> {{ _degree.discipline }} {{ _degree.year }}, {{ _degree.institute }}
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>

                    <template v-if='interests.length'>
                        <div class="FAC-interests-sm FACborder-line-wrapper ">
                            <h6>INTERESTS</h6>
                            <template v-for='_interest in interests'>
                                <a class="badge badge-primary py-2 px-2 my-1" href="#">
                                    {{ _interest.title }}
                                </a>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
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
        badges: []
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
    }
  },
  methods: {
    loadMetadata: function() {
        return axios.get(
            'people/' + $("meta[name=person-uri]").attr('content'),
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
                    email: $("meta[name=person-email]").attr('content')
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
                    email: $("meta[name=person-email]").attr('content')
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
            this.contact = person_data.primary_connection.pivot;
            this.degrees = person_data.degrees;
            this.biography = person_data.biography;

            // apply the interests
            var interest_data = interests.data;
            this.interests = interest_data.interests;

            // apply the badges
            var badges_data = badges.data;
            this.badges = badges_data.badges;
        }));
  }
}
</script>