<template>
    <div id="students">
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
                <div class="row justify-content-center">   
                    <div class="col-md-8">
                        <div class="d-none d-md-block">
                            <h2 class="h3 text-primary mb-4">Students</h2>
                            <h3 class="font-display">Completed Master Theses:</h3>
                        </div>
                        <template v-if="publications.length">
                            <div class="profilePublicationWrapper">
                                <div v-for="(publication, index) in orderedPublications" class="profilePublication card card--styled d-block mb-3" :data-type="publication.type" :id="'profilePublication--'+index">
                                    <div class="card-header bg-white" :id="'heading--'+index" data-toggle="collapse" :data-target="'#collapse--'+index" aria-expanded="false" :aria-controls="'#collapse--'+index">
                                        <div class="profilePublication__publication">
                                            <template v-if="publication.document.handle.split('http://hdl.handle.net')[1]">
                                                <a @click.stop :href="'http://scholarworks.csun.edu/handle' + publication.document.handle.split('http://hdl.handle.net')[1]" target="scholarworks">
                                                    <template v-if="publication.formatted != ''">
                                                        <span v-html="publication.formatted"></span>
                                                    </template>
                                                    <template v-else>
                                                        <span v-html="publication.metadata.title"></span>
                                                    </template>
                                                    <sup><i class="fas fa-external-link-alt"></i></sup>
                                                </a>
                                            </template>
                                            <template v-else>
                                                <template v-if="publication.formatted != ''">
                                                    <span v-html="publication.formatted"></span>
                                                </template>
                                                <template v-else>
                                                    <span v-html="publication.metadata.title"></span>
                                                </template>
                                            </template>
                                        </div>
                                        <span class="text-capitalize">
                                            Chair:
                                        </span>
                                        <a @click.stop class="text-underline text-body" :href="'/' + publication.membership.members[1].email.split('@')[0] + '#/students'">{{publication.membership.members[1].display_name}}</a>
                                        

                                        <span class="text-capitalize pl-2">
                                            Members:
                                        </span>
                                        <span>
                                            <template v-for="(member, index) in publication.membership.members">
                                                <template v-if="index > 1">
                                                    <a @click.stop class="text-underline text-body" :href="'/' + member.email.split('@')[0] + '#/students'">{{member.display_name}}</a><template v-if="index !== publication.membership.members.length-1">, </template>
                                                </template>
                                            </template>
                                        </span>

                                        <div class="d-flex justify-content-center justify-content-sm-end align-items-center flex-wrap">
                                            <div>
                                                <div class="btn btn-outline-dark btn-sm btn-rounded mt-3 mt-sm-0"><span class="is--collapsed">Show</span><span class="is--expanded">Hide</span> Details <i class="fas fa-chevron-down"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div :id="'collapse--'+index" class="collapse" :aria-labelledby="'heading--'+index">
                                        <div class="card-body">
                                            <div class="mt-4 mb-3" v-if="publication.metadata.title">
                                                <div class="font-weight-bold">Title:</div>
                                                <span>{{publication.metadata.title}}</span>
                                            </div>

                                            <div class="mt-4 mb-3" v-if="publication.published.date">
                                                <div class="font-weight-bold">Date: </div>
                                                {{returnPublicationDate(publication.published.date)}}
                                            </div>

                                            <div class="mt-4 mb-3" v-if="publication.metadata.journal">
                                                <div class="font-weight-bold">Journal:</div>
                                                <span>{{publication.metadata.journal }}</span>
                                            </div>

                                            <template v-if="publication.publisher">
                                                <div class="mt-4 mb-3" v-if="publication.publisher.publisher">
                                                    <div class="font-weight-bold">Publisher:</div>
                                                    <span>{{publication.publisher.publisher }}</span>
                                                </div>
                                            </template>
                                            <div class="mt-4 mb-3" v-if="publication.metadata.abstract">
                                                <div class="font-weight-bold">Abstract:</div>
                                                <span>{{ publication.metadata.abstract }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="mb-2">There are currently no theses to display.</div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ProfileStudents',
    data: function () {
        return {
            publications: [],
            windowWidth: 0,
            isMobile: false,
            isDesktop: false,
            loading_all: true
        }
    },
    mounted() {
        this.$nextTick(function() {
            window.addEventListener('resize', this.getWindowWidth);
            //Init
            this.getWindowWidth()
        });

        var vm = this;
        axios.get(
            'citations/theses',
            {
                baseURL: $('meta[name=citations-url]').attr('content'),
                params: {
                    email: this.person_email
                }
            }
        )       
        .then(function (response) {
            if (response.data.theses != null) {
                vm.publications = response.data.theses;
            }
            
            vm.loading_all = false;
        });
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.getWindowWidth);
    },
    computed: {
        person_email: function() {
            return $("meta[name=person-email]").attr('content');
        },
        orderedPublications: function () {
            return _.orderBy(this.publications, 'published.date', 'desc');
        }
    },
    methods: {
        returnPublicationDate: function(date) {
            var finalDate = date
            if( date.length > 4) {
                finalDate = moment(date).format('MMMM Do YYYY');
            } 
            return finalDate
        },
        getWindowWidth() {
            this.windowWidth = document.documentElement.clientWidth;

            if ( this.windowWidth > 767 ) {
                this.isMobile = false;
                this.isDesktop = true;
            } else {
                this.isMobile = true;
                this.isDesktop = false;         
            }
        }
    }
}
</script>
