<template>
    <div id="projects">
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
                            <h2 class="h3 text-primary mb-4 float-left">Projects</h2>
                            <div v-if="projects.length" class="btn btn-sm btn-secondary float-right" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters"> 
                                <i class="fas fa-sliders-h"></i> Filters <span v-if="selectedFilters.length > 0">({{ selectedFilters.length }})</span>
                            </div>
                        </div>

                        <template v-if="projects.length">
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
                        </template>

                        <div class="d-none d-md-block">
                            <h6 class="h5 mb-4" v-bind:class="{'mt-5': projects.length}">RESEARCH INTERESTS</h6>
                            <template v-if="interests.length">
                                <a :href="generateInterestSearchUrl(_interest)" v-for="_interest in interests" class="badge  badge-danger badge--profile-interests py-2 px-2 my-1 mr-1" target="_blank">
                                    {{ _interest.title }}
                                </a>
                            </template>
                            <template v-else>
                                There are currently no research interests to display.
                            </template>
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

                        <template v-if="projects.length">
                            <template v-if="displayedProjects.length">
                                <div class="mb-2">Showing <strong>{{ displayedProjects.length }}</strong> of <strong>{{ projects.length }}</strong> project(s)</div>

                                <div v-for="project in displayedProjects" class="profileProject">
                                    <a class="profileProject__title" :href="generateProjectUrl(project)" target="_blank">
                                        {{ project.project_title }}
                                    </a>
                                    <div v-if="project.attributes" class="profileProject__type">
                                        <span v-if="project.attributes.purpose_name == 'creative'">Creative Work</span>
                                        <span v-else>{{ uppercaseFirstLetter(project.attributes.purpose_name) }}</span>
                                    </div>
                                    <div v-if="project.award.length" class="profileProject__item">
                                        <template v-for="award_sponsor in project.award_sponsors">
                                            <p><strong>{{ award_sponsor.sponsor }}:</strong> {{ new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}).format(award_sponsor.total) }}</p>
                                        </template>
                                    </div>
                                    <div v-if="project.pi" class="profileProject__item">
                                        <strong>Lead Principal Investigator:</strong> {{ project.pi.display_name }}
                                    </div>
                                    <div v-if="project.members.length" class="profileProject__item">
                                        <strong>Team:</strong> {{ renderProjectTeamList(project) }}
                                    </div>
                                </div>
                            </template>
                            <template v-else>
                                <div class="mb-2">There are currently no projects that match your selected filters.</div>
                            </template>
                        </template>
                        <template v-else>
                            <div class="mb-2">There are currently no projects to display.</div>
                        </template>

                        <div class="d-block d-md-none">
                            <h6 class="h5 mb-4 mt-5">RESEARCH INTERESTS</h6>
                            <template v-if="interests.length">
                                <a :href="generateInterestSearchUrl(_interest)" v-for="_interest in interests" class="badge  badge-danger badge--profile-interests py-2 px-2 my-1 mr-1" target="_blank">
                                    {{ _interest.title }}
                                </a>
                            </template>
                            <template v-else>
                                There are currently no research interests to display.
                            </template>
                        </div>

                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ProfileProjects',
    data: function () {
        return {
            projects: [],
            interests: [],
            roleFilters: ['Investigator','Other Faculty','Principal Investigator','Former Principal Investigator','Lead Principal Investigator','Project Manager','Proposal Editor'],
            statusFilters: ['Active','Completed'],
            typeFilters: ['Creative Work','Project','Research','Service'],
            selectedFilters: [],
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

        // make the Axios calls concurrently and wait for all of them to return
        // before applying the reactive data
        axios.all([this.loadProjects(), this.loadResearchInterests()])
            .then(axios.spread((projects, interests) => {
                // apply the projects
                if(projects.data.projects != null) {
                    this.projects = projects.data.projects;
                }
                else
                {
                    this.projects = [];
                }

                // filter out any non-publishable projects
                this.projects = this.projects.filter(function(project) {
                    return project.is_publishable == "1";
                });

                // calculate the total awarded amount for the project
                // per individual sponsor
                this.projects.forEach(function(project) {
                    project.award_sponsors = [];
                    if(project.award.length) {
                        let awardMap = new Map();
                        project.award.forEach(function(award) {
                            let awardAmount = parseFloat(award.award_amount);
                            if(awardAmount > 0.00) {
                                if(!awardMap.has(award.sponsor_code)) {
                                    let award_sponsor_data = {
                                        sponsor: award.sponsor,
                                        total: awardAmount
                                    };
                                    awardMap.set(award.sponsor_code, award_sponsor_data);
                                }
                                else
                                {
                                    let award_sponsor_data = awardMap.get(award.sponsor_code);
                                    award_sponsor_data.total += awardAmount;
                                    awardMap.set(award.sponsor_code, award_sponsor_data);
                                }
                            }
                        });
                        awardMap.forEach(function(award_sponsor_data) {
                            project.award_sponsors.push(award_sponsor_data);
                        });
                    }
                });

                // apply the research interests
                this.interests = interests.data.interests;

                // we have finished loading everything
                this.loading_all = false;
            }));
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.getWindowWidth);
    },
    computed: {
        // this computed property filters the set of projects brought in from
        // the projects API based upon the set of selected filters
        displayedProjects: function() {
            // if there are no selected filters, just return the entire set of
            // projects
            if(!this.selectedFilters.length) {
                return this.projects;
            }

            // iterate over the set of selected filters and apply each one to
            // the set of projects; selection of multiple filters results in
            // essentially a chained set of logical OR statements
            let displayedProjects = [];
            this.selectedFilters.forEach((filter) => {
                let filteredProjects = this.applyFilter(filter);

                // filter the filtered projects to ensure they do not already
                // exist in the set of already-displayed projects
                filteredProjects = filteredProjects.filter(function(project) {
                    // I'm using a regular "for" loop and not a forEach() or a
                    // for...of for a very specific reason here
                    for(let i = 0; i < displayedProjects.length; i++) {
                        if(displayedProjects[i].project_id == project.project_id) {
                            // project already exists in the displayed set
                            return false;
                        }
                    }

                    // project either does not already exist or there are currently
                    // no displayed projects so it should be added anyway
                    return true;
                });

                // now push each still-existing filtered project onto the set of
                // displayed projects
                filteredProjects.forEach(function(project) {
                    displayedProjects.push(project);
                });
            });

            return displayedProjects;
        },
        person_email: function() {
            return $("meta[name=person-email]").attr('content');
        },
        projectRoleMap: function() {
            // different decisions have to be made based upon the role name so
            // we will create a Map instance
            let roles = new Map();
            this.roleFilters.forEach(function(role) {
                if(role == 'Former Principal Investigator') {
                    // this role is referred to as "Former PI" in the WS
                    roles.set(role, 'Former PI');
                }
                else
                {
                    // all other roles are equivalent
                    roles.set(role, role);
                }
            });
            return roles;
        },
        projectTypeMap: function() {
            // the type system name comes back, not the display name, so we
            // need a way to dereference the system name
            let types = new Map();
            this.typeFilters.forEach(function(type) {
                if(type == 'Creative Work') {
                    types.set(type, 'creative');
                }
                else
                {
                    // everything except Creative Work is just the lower-case
                    // variant of the type
                    types.set(type, type.toLowerCase());
                }
            });
            return types;
        },
        scholarship_url: function() {
            return $("meta[name=helix-url]").attr('content');
        },
    },
    methods: {
        loadProjects: function() {
            return axios.get(
                'members/projects',
                {
                    baseURL: $('meta[name=projects-url').attr('content'),
                    params: {
                        email: this.person_email
                    }
                }
            );
        },
        loadResearchInterests: function() {
            return axios.get(
                'interests/research',
                {
                    baseURL: $("meta[name=affinity-url]").attr('content'),
                    params: {
                        email: this.person_email
                    }
                }
            );
        },
        applyFilter: function(filter) {
            // figure out the type of the specified filter
            if(this.roleFilters.indexOf(filter) != -1) {
                // member role filter
                return this.applyRoleFilter(filter);
            }
            
            if(this.statusFilters.indexOf(filter) != -1) {
                // project status filter
                return this.applyStatusFilter(filter);
            }

            if(this.typeFilters.indexOf(filter) != -1) {
                // project type filter
                return this.applyTypeFilter(filter);
            }

            // unknown filter, so return an empty array of projects in order
            // to prevent overriding all other filters further down the
            // line
            return [];
        },
        applyRoleFilter: function(filter) {
            // apply a filter to a copy of the projects array based upon
            // a given member role
            let filteredProjects = this.projects.slice(0);

            // now actually filter the projects by the member role name
            let roleName = this.projectRoleMap.get(filter);
            filteredProjects = filteredProjects.filter(function(project) {
                return project.role_position == roleName;
            });

            return filteredProjects;
        },
        applyStatusFilter: function(filter) {
            // apply a filter to a copy of the projects array based upon
            // a specific project status
            let filteredProjects = this.projects.slice(0);

            // filter the projects based upon project end date or lack thereof
            filteredProjects = filteredProjects.filter(function(project) {
                if(filter == 'Active') {
                    if(!project.project_end_date) {
                        // no end date, so assume the project is still active
                        return true;
                    }
                    // compare end date to current date with moment.js
                    return moment().isSameOrBefore(project.project_end_date, 'day');
                }
                else if(filter == 'Completed') {
                    if(!project.project_end_date) {
                        // no end date, so assume the project is still active
                        return false;
                    }
                    // compare end date to current date with moment.js
                    return moment().isAfter(project.project_end_date, 'day');
                }

                // unknown status filter so filter out this project to prevent
                // overriding other filters further down the line
                return false;
            });

            return filteredProjects;
        },
        applyTypeFilter: function(filter) {
            // apply a filter to a copy of the projects array based upon
            // a specific project type
            let filteredProjects = this.projects.slice(0);

            // now actually filter the projects by the system name of the purpose
            let purpose = this.projectTypeMap.get(filter);
            filteredProjects = filteredProjects.filter(function(project) {
                if(!project.attributes) {
                    return false;
                }
                return project.attributes.purpose_name == purpose;
            });

            return filteredProjects;
        },
        uppercaseFirstLetter: function(str) {
            // https://dzone.com/articles/how-to-capitalize-the-first-letter-of-a-string-in
            return str.charAt(0).toUpperCase() + str.slice(1);
        },
        renderProjectTeamList: function(project) {
            // returns a comma-separated string representing the members on
            // a project; if no members exist, it returns a blank string
            if(!project.members.length) {
                return "";
            }
            let nameArr = [];
            project.members.forEach(function(member) {
                nameArr.push(member.display_name);
            });
            return nameArr.join(', ');
        },
        generateProjectUrl: function(project) {
            return this.scholarship_url + 'project/' + project.slug;
        },
        generateInterestSearchUrl: function(interest) {
            return this.scholarship_url + 'search/research-interests?searchType=research-interest&query=' +
                interest.title.split(" ").join("+");
        },
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
