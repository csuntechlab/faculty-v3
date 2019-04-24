<template>
    <div id="citations">
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
                    <div class="col-md-4">
                        
                        <div class="clearfix" v-bind:class="{ 'd-block': isMobile, 'd-none': isDesktop }">
                            <h2 class="h3 text-primary mb-4 float-left">Citations</h2>
                            <div v-if="citations.length" class="btn btn-sm btn-secondary float-right" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters"> 
                                <i class="fas fa-sliders-h"></i> Filters <span v-if="selectedFilters.length > 0">({{ selectedFilters.length }})</span>
                            </div>
                        </div>
                        
                        <template v-if="citations.length">
                            <div v-bind:class="{ 'collapse clearfix': isMobile, 'collapse show': isDesktop }" id="collapseFilters">
                                <h6 class="h5 mb-4 d-none d-md-block">CITATION FILTERS</h6>
                                <ul class="projectFilterList list-unstyled">
                                    <li>
                                        <strong>Citation Type</strong>
                                    </li>
                                    <li v-for="filter in typeFiltersObject">
                                        <div class="custom-control custom-checkbox">
                                            <input 
                                                type="checkbox" 
                                                class="custom-control-input projectFilterList__checkbox" 
                                                v-bind:data-singular="filter.singular.replace(/\s/g, '')"
                                                v-bind:ref="'role-' + filter.plural.replace(/\s/g, '')"
                                                v-bind:id="'role-' + filter.plural.replace(/\s/g, '')"
                                                v-on:click="filterCheckboxWasClicked($event)" 
                                                v-bind:value="filter.plural"
                                            >
                                            <label class="custom-control-label" v-bind:for="'role-' + filter.plural.replace(/\s/g, '')">{{ filter.plural }}</label>
                                        </div>
                                    </li>
                                </ul>
                                <div class="projectFilterList__clear" v-on:click="ClearAllWasClicked($event)">Clear All Filters</div>
                            </div>
                        </template>
                    </div>

                    <div class="col-md-8">
                        <div class="d-none d-md-block">
                            <h2 class="h3 text-primary mb-4">Citations</h2>

                            <div class="projectFilterBar" id="projectFilterBar">
                            
                                <strong class="projectFilterBar__label">Filtered By:</strong> 
                            
                                <span v-if="typeFiltersObject" v-for="filter in typeFiltersObject" v-bind:id="'badge-' + filter.plural.replace(/\s/g, '')" class="badge badge-primary projectFilterBar__badge py-2 px-2 my-1 mr-1">
                                    {{ filter.plural }} 
                                    <span 
                                        class="projectFilterBar__remove"
                                        v-bind:ref="'badge-remove-' + filter.plural.replace(/\s/g, '')"
                                        v-bind:id="'badge-remove-' + filter.plural.replace(/\s/g, '')"
                                        v-on:click="filterBadgeWasClicked($event)"
                                    >
                                        x
                                    </span>
                                </span>
                            </div>
                        </div>
                        
                        <template v-if="citations.length">
                            <template v-if="aFilterHasBeenApplied">
                                <div class="mb-2">Showing <strong>{{ filteredCitations.length }}</strong> of <strong>{{ citations.length }}</strong> citations</div>
                            </template>
                            <template v-else>
                                <div class="mb-2">Showing <strong>{{ citations.length }}</strong> of <strong>{{ citations.length }}</strong> citations</div>
                            </template>
                        </template>
                        
                        <template v-if="citations.length">
                            <div class="profileCitationWrapper">
                                <div v-for="(citation, index) in orderedCitations" class="profileCitation card card--styled d-block mb-3" :data-type="citation.type" :id="'profileCitation--'+index">
                                    <div class="card-header bg-white" :id="'heading--'+index" data-toggle="collapse" :data-target="'#collapse--'+index" aria-expanded="false" :aria-controls="'#collapse--'+index">
                                        <div class="profileCitation__citation">
                                            <template v-if="citation.formatted != ''">
                                                <span v-html="citation.formatted"></span>
                                            </template>
                                            <template v-else>
                                                <span v-html="citation.metadata.title"></span>
                                            </template>
                                        </div>
                                        <div class="d-flex justify-content-center justify-content-sm-end align-items-center flex-wrap">
                                            <div class="text-wrap pr-5 py-2" v-if="citation.published.date">
                                                <strong>Year: </strong>
                                                {{ returnCitationYear(citation.published.date) }}
                                            </div>

                                            <div class="text-wrap pr-5 py-2" v-if="citation.type">
                                                <strong>Type: </strong>
                                                <span class="text-capitalize">{{ citation.type }}</span>
                                            </div>

                                            <div>
                                                <div class="btn btn-outline-dark btn-sm btn-rounded mt-3 mt-sm-0"><span class="is--collapsed">Show</span><span class="is--expanded">Hide</span> Details <i class="fas fa-chevron-down"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div :id="'collapse--'+index" class="collapse" :aria-labelledby="'heading--'+index">
                                        <div class="card-body">
                                            <div class="mt-4 mb-3" v-if="citation.metadata.title">
                                                <div class="font-weight-bold">Title:</div>
                                                <span>{{citation.metadata.title}}</span>
                                            </div>

                                            <div class="mt-4 mb-3" v-if="citation.membership.members.length > 1">
                                                <div class="font-weight-bold">Collaborators:</div>
                                                <template v-for="(member, index) in citation.membership.members">
                                                    <span>
                                                        {{member.display_name}}<template v-if="index !== (citation.membership.members.length-1)">,</template>
                                                    </span>
                                                </template>
                                            </div>

                                            <div class="mt-4 mb-3" v-if="citation.published.date">
                                                <div class="font-weight-bold">Date: </div>
                                                {{returnCitationDate(citation.published.date)}}
                                            </div>

                                            <div class="mt-4 mb-3" v-if="citation.metadata.journal">
                                                <div class="font-weight-bold">Journal:</div>
                                                <span>{{citation.metadata.journal }}</span>
                                            </div>

                                            <template v-if="citation.publisher">
                                                <div class="mt-4 mb-3" v-if="citation.publisher.publisher">
                                                    <div class="font-weight-bold">Publisher:</div>
                                                    <span>{{citation.publisher.publisher }}</span>
                                                </div>
                                            </template>

                                            <div class="mt-4 mb-3" v-if="citation.metadata.abstract">
                                                <div class="font-weight-bold">Abstract:</div>
                                                <span>{{ citation.metadata.abstract }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="mb-2">There are currently no citations to display.</div>
                        </template>

                        <template v-if="aFilterHasBeenApplied && !filteredCitations.length">
                            <div class="mb-2">There are currently no citations that match your selected filters.</div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ProfileCitations',
    data: function () {
        return {
            citations: [],
            filteredCitations: [],
            typeFiltersObject: [ 
                {
                    plural: 'Articles',
                    singular: 'article'
                },
                {
                    plural: 'Books',
                    singular: 'book' 
                },
                {
                    plural: 'Chapters',
                    singular: 'chapter' 
                },
                {
                    plural: 'Presentations',
                    singular: 'presentation' 
                },
                {
                    plural: 'Thesis',
                    singular: 'thesis' 
                }
            ],
            selectedFilters: [],
            aFilterHasBeenApplied: false,
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
            'citations',
            {
                baseURL: $('meta[name=citations-url]').attr('content'),
                params: {
                    email: this.person_email
                }
            }
        )       
        .then(function (response) {
            if (response.data.citations != null) {
                vm.citations = response.data.citations;
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
        orderedCitations: function () {
            return _.orderBy(this.citations, 'published.date', 'desc');
        }
    },
    methods: {
        returnCitationYear: function(date) {
            var year = date
            if( date.length > 4) {
                year = moment(date).format('YYYY');
            } 
            return year
        },
        returnCitationDate: function(date) {
            var finalDate = date
            if( date.length > 4) {
                finalDate = moment(date).format('MMMM Do YYYY');
            } 
            return finalDate
        },
        filterCheckboxWasClicked : function(event) {
            var correspondingBadge = document.getElementById(event.target.id.replace(/role/i, 'badge'))

            if (event.target.checked) {
                correspondingBadge.classList.add('active');
                this.selectedFilters.push(event.target.value)
                
                this.applyTheFilter(event);
                
            } else {
                correspondingBadge.classList.remove('active');
                var index = this.selectedFilters.indexOf(event.target.value);    // <-- Not supported in <IE9
                if (index !== -1) {
                    this.selectedFilters.splice(index, 1);
                }

                this.removeTheFilter(event);
            }

            this.checkIfAFilterHasBeenApplied();
        },
        applyTheFilter : function(event) {
            var vm = this;
            var singularSelectedFilter = event.target.getAttribute('data-singular');

            Array.from(document.querySelectorAll('.profileCitation')).forEach(function (item, index) {
                var itemType = item.getAttribute('data-type');
                if (itemType == singularSelectedFilter ) {
                    item.classList.add("is-filtered");
                    vm.filteredCitations.push(item);
                }
            });                      
        },
        removeTheFilter : function(event) {
            var vm = this;
            var singularSelectedFilter = event.target.getAttribute('data-singular');

            Array.from(document.querySelectorAll('.profileCitation')).forEach(function (item, index) {
                var itemType = item.getAttribute('data-type');
                if (itemType == singularSelectedFilter ) {
                    item.classList.remove("is-filtered");
                    
                    for(var i = vm.filteredCitations.length - 1; i >= 0; i--) {
                        if(vm.filteredCitations[i] === item) {
                            vm.filteredCitations.splice(i, 1);
                        }
                    }
                }
            });                      
        },
        filterBadgeWasClicked : function(event) {
            var correspondingCheckbox = document.getElementById(event.target.id.replace(/badge-remove/i, 'role'));
            correspondingCheckbox.click()
        },
        ClearAllWasClicked : function(event) {
            var checkboxes = document.getElementsByClassName("projectFilterList__checkbox");
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked ) {
                    checkboxes[i].click()
                } 
            }

            this.checkIfAFilterHasBeenApplied();
        },
        checkIfAFilterHasBeenApplied : function() {
            var projectFilterBar = document.getElementById("projectFilterBar")
            var profileCitationWrapper = document.querySelector(".profileCitationWrapper");
            
            if (this.selectedFilters.length !== 0) {
                projectFilterBar.classList.add('active');
                profileCitationWrapper.classList.add('profileCitationWrapper--filters-applied');
                this.aFilterHasBeenApplied = true;
            } else {
                projectFilterBar.classList.remove('active');
                profileCitationWrapper.classList.remove('profileCitationWrapper--filters-applied');
                this.aFilterHasBeenApplied = false;
            }
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
