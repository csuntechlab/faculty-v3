<template>
    <div id="projects">
        <div class="container">
            <div class="row">                 
                <div class="col-md-4">

                    <div class="clearfix" v-bind:class="{ 'd-block': isMobile, 'd-none': isDesktop }">
                        <h2 class="h3 text-primary mb-4 float-left">Projects</h2>
                        <div class="btn btn-sm btn-secondary float-right" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters"> 
                            <i class="fas fa-sliders-h"></i> Filters <span v-if="selectedFilters.length > 0">({{ selectedFilters.length }})</span>
                        </div>
                    </div>

                    <div v-bind:class="{ 'collapse clearfix': isMobile, 'collapse show': isDesktop }" id="collapseFilters">
                        <h6 class="h5 mb-4 d-none d-md-block">PROJECT FILTERS</h6>
                        <ul class="projectFilterList list-unstyled">
                            <li>
                                <strong>Project Role</strong>
                            </li>
                            <li v-for="filter in roleFilters">
                                <div class="custom-control custom-checkbox">
                                    <input 
                                        type="checkbox" 
                                        class="custom-control-input projectFilterList__checkbox" 
                                        v-bind:ref="'role-' + filter.replace(/\s/g, '')"
                                        v-bind:id="'role-' + filter.replace(/\s/g, '')"
                                        v-on:click="filterCheckboxWasClicked($event)" 
                                        v-bind:value="filter"
                                    >
                                    <label class="custom-control-label" v-bind:for="'role-' + filter.replace(/\s/g, '')">{{ filter }}</label>
                                </div>
                            </li>
                        </ul>

                        <ul class="projectFilterList list-unstyled">
                            <li>
                                <strong>Project Status</strong>
                            </li>
                            <li v-for="filter in statusFilters">
                                <div class="custom-control custom-checkbox">
                                    <input 
                                        type="checkbox" 
                                        class="custom-control-input projectFilterList__checkbox" 
                                        v-bind:ref="'role-' + filter.replace(/\s/g, '')"
                                        v-bind:id="'role-' + filter.replace(/\s/g, '')"
                                        v-on:click="filterCheckboxWasClicked($event)" 
                                        v-bind:value="filter"
                                    >
                                    <label class="custom-control-label" v-bind:for="'role-' + filter.replace(/\s/g, '')">{{ filter }}</label>
                                </div>
                            </li>
                        </ul>

                        <ul class="projectFilterList list-unstyled">
                            <li>
                                <strong>Project Type</strong>
                            </li>

                            <li v-for="filter in typeFilters">
                                <div class="custom-control custom-checkbox">
                                    <input 
                                        type="checkbox" 
                                        class="custom-control-input projectFilterList__checkbox" 
                                        v-bind:ref="'role-' + filter.replace(/\s/g, '')"
                                        v-bind:id="'role-' + filter.replace(/\s/g, '')"
                                        v-on:click="filterCheckboxWasClicked($event)" 
                                        v-bind:value="filter"
                                    >
                                    <label class="custom-control-label" v-bind:for="'role-' + filter.replace(/\s/g, '')">{{ filter }}</label>
                                </div>
                            </li>
                        </ul>
                        <div class="projectFilterList__clear" v-on:click="ClearAllWasClicked($event)">Clear All Filters</div>
                    </div>

                    <div class="d-none d-md-block">
                        <h6 class="h5 mb-4 mt-5">RESEARCH INTERESTS</h6>
                        <span class="badge  badge-danger badge--profile-interests py-2 px-2 my-1 mr-1">
                            Foo
                        </span>
                        <span class="badge  badge-danger badge--profile-interests py-2 px-2 my-1 mr-1">
                            Bar
                        </span>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="d-none d-md-block">
                        <h2 class="h3 text-primary mb-4">Projects</h2>

                        <div class="projectFilterBar" id="projectFilterBar">
                        
                            <strong class="projectFilterBar__label">Filtered By:</strong> 
                        
                            <span v-if="roleFilters" v-for="filter in roleFilters" v-bind:id="'badge-' + filter.replace(/\s/g, '')" class="badge badge-primary projectFilterBar__badge py-2 px-2 my-1 mr-1">
                                {{ filter }} 
                                <span 
                                    class="projectFilterBar__remove"
                                    v-bind:ref="'badge-remove-' + filter.replace(/\s/g, '')"
                                    v-bind:id="'badge-remove-' + filter.replace(/\s/g, '')"
                                    v-on:click="filterBadgeWasClicked($event)"
                                >
                                    x
                                </span>
                            </span>
                        
                            <span v-if="statusFilters" v-for="filter in statusFilters" v-bind:id="'badge-' + filter.replace(/\s/g, '')" class="badge badge-primary projectFilterBar__badge py-2 px-2 my-1 mr-1">
                                {{ filter }} 
                                <span 
                                    class="projectFilterBar__remove"
                                    v-bind:ref="'badge-remove-' + filter.replace(/\s/g, '')"
                                    v-bind:id="'badge-remove-' + filter.replace(/\s/g, '')"
                                    v-on:click="filterBadgeWasClicked($event)"
                                >
                                    x
                                </span>
                            </span>

                            <span v-if="typeFilters" v-for="filter in typeFilters" v-bind:id="'badge-' + filter.replace(/\s/g, '')" class="badge badge-primary projectFilterBar__badge py-2 px-2 my-1 mr-1">
                                {{ filter }} 
                                <span 
                                    class="projectFilterBar__remove"
                                    v-bind:ref="'badge-remove-' + filter.replace(/\s/g, '')"
                                    v-bind:id="'badge-remove-' + filter.replace(/\s/g, '')"
                                    v-on:click="filterBadgeWasClicked($event)"
                                >
                                    x
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="mb-2">Showing <strong>2</strong> of <strong>20</strong> projects</div>

                    <div class="profileProject">
                        <a class="profileProject__title" href="#">
                            CSUN-UCLA Stem Cell Scientest Training Program
                        </a>
                        <div class="profileProject__type">
                            Project
                        </div>
                        <div class="profileProject__item">
                            <strong>NFS:</strong> $2,770,000
                        </div>
                        <div class="profileProject__item">
                            <strong>Lead Principle Investigator:</strong> Cindy Malone
                        </div>
                        <div class="profileProject__item">
                            <strong>Team:</strong> Cindy Malone, Shina Dunkin, Anton Garraway, Bradly Luskby, Marge Mintz, Giovonni Nios, Otellia Kopzyanucy
                        </div>
                    </div>

                    <div class="profileProject">
                        <a class="profileProject__title" href="#">
                            RUI/Collaborative Research: MSB-ECA: Mice-o-scapes: Using isotopes to understand the effect of climate and landscape change on small mammal ecology over the past 100 years
                        </a>
                        <div class="profileProject__type">
                            Project
                        </div>
                        <div class="profileProject__item">
                            <strong>NFS:</strong> $2,770,000
                        </div>
                        <div class="profileProject__item">
                            <strong>Lead Principle Investigator:</strong> Cindy Malone
                        </div>
                        <div class="profileProject__item">
                            <strong>Team:</strong> Cindy Malone, Shina Dunkin, Marge Mintz, Giovonni Nios
                        </div>
                    </div>

                    <div class="d-block d-md-none">
                        <h6 class="h5 mb-4 mt-5">RESEARCH INTERESTS</h6>
                        <span class="badge  badge-danger badge--profile-interests py-2 px-2 my-1 mr-1">
                            Foo
                        </span>
                        <span class="badge  badge-danger badge--profile-interests py-2 px-2 my-1 mr-1">
                            Bar
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ProfileProjects',
    data: function () {
        return {
            roleFilters: ['Investigator','Other Faculty','Principle Investigator','Former Principle Investigator','Lead Principle Investigator','Project Manager','Proposal Editor'],
            statusFilters: ['Active','Completed'],
            typeFilters: ['Creative Work','Project','Research','Service'],
            selectedFilters: [],
            windowWidth: 0,
            isMobile: false,
            isDesktop: false
        }
    },
    mounted() {
        this.$nextTick(function() {
            window.addEventListener('resize', this.getWindowWidth);
            //Init
            this.getWindowWidth()
        })
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.getWindowWidth);
    },
    methods: {
        filterCheckboxWasClicked : function(event) {
            var correspondingBadge = document.getElementById(event.target.id.replace(/role/i, 'badge'))

            if (event.target.checked) {
                correspondingBadge.classList.add('active');
                this.selectedFilters.push(event.target.value)
            } else {
                correspondingBadge.classList.remove('active');
                var index = this.selectedFilters.indexOf(event.target.value);    // <-- Not supported in <IE9
                if (index !== -1) {
                    this.selectedFilters.splice(index, 1);
                }
            }

            this.checkIfProjectFilterBarShouldBeDisplayed();
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

            this.checkIfProjectFilterBarShouldBeDisplayed();
        },
        checkIfProjectFilterBarShouldBeDisplayed : function() {
            var projectFilterBar = document.getElementById("projectFilterBar")
            
            if (this.selectedFilters.length !== 0) {
                projectFilterBar.classList.add('active');
            } else {
                projectFilterBar.classList.remove('active');
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
