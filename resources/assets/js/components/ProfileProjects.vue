<template>
    <div id="projects">
        <div class="container">
            <div class="row">                 
                <div class="col-md-4 order-last order-md-first">
                    <h6 class="h5 mb-4">PROJECT FILTERS</h6>
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

                        <li class="projectFilterList__clear" v-on:click="ClearAllWasClicked($event)">Clear All Filters</li>
                    </ul>

                    <h6 class="h5 mb-4 mt-5">RESEARCH INTERESTS</h6>
                    <span class="badge  badge-danger badge--profile-interests py-2 px-2 my-1 mr-1">
                        Foo
                    </span>
                    <span class="badge  badge-danger badge--profile-interests py-2 px-2 my-1 mr-1">
                        Bar
                    </span>

                </div>

                <div class="col-md-8 order-first order-md-last">
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

                    <h2 class="h3 text-primary mb-4">Projects</h2>

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
            selectedFilters: []
        }
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

            var projectFilterBar = document.getElementById("projectFilterBar")
            
            if (this.selectedFilters.length !== 0) {
                projectFilterBar.classList.add('active');
            } else {
                projectFilterBar.classList.remove('active');
            }
        },
        filterBadgeWasClicked : function(event) {
            var correspondingCheckbox = document.getElementById(event.target.id.replace(/badge-remove/i, 'role'));
            var parentBadge = document.getElementById(event.target.id.replace(/badge-remove/i, 'badge'));

            correspondingCheckbox.checked = false;
            parentBadge.classList.remove('active');
            
        },
        ClearAllWasClicked : function(event) {
            var checkboxes = document.getElementsByClassName("projectFilterList__checkbox");

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked ) {
                    checkboxes[i].click()
                } 
            }     
        }
    }
}
</script>
