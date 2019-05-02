<template>
    <div id="classes">
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
                    <div class="order-last order-md-first col-md-4 pt-3 pt-md-0">
                        <div class="mb-3 pb-3">
                            <h6 class="h5 mb-3">TEACHING INTERESTS</h6>
                            <template v-if="teaching_interest.length">
                                <template v-for="interest in teaching_interest">
                                    <span class="badge  badge-danger badge--profile-interests py-2 px-2 my-1 mr-1">
                                        {{interest.title}}
                                    </span>                                
                                </template>
                            </template>
                            <template v-else>
                                <span class="empty-state-msg">There are currently no teaching interests to display.</span>
                            </template>
                        </div>

                        <div class="mb-3 pb-3">
                            <h6 class="h5 mb-3">PAST COURSES</h6>
                            <template v-if='past_courses.length'>  
                                <ul class="past-courses-list list-unstyled">
                                    <template v-for='_past_course in past_courses.slice(0, 3)'>
                                        <li>
                                            <strong>{{ _past_course.subject }} {{ _past_course.catalog_number }}</strong>
                                            <div>{{ _past_course.title }}</div>
                                            <div>Last Offered {{ _past_course.last_taught }}</div>
                                            <div>
                                                Taught {{ _past_course.times_taught }} section<template v-if='_past_course.times_taught > 1'>s</template>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                                <ul class="past-courses-list list-unstyled collapse" id="collapseExample">
                                    <template v-for='_past_course in past_courses.slice(3)'>
                                        <li>
                                            <strong>{{ _past_course.subject }} {{ _past_course.catalog_number }}</strong>
                                            <div>{{ _past_course.title }}</div>
                                            <div>Last Offered {{ _past_course.last_taught }}</div>
                                            <div>
                                                Taught {{ _past_course.times_taught }} section<template v-if='_past_course.times_taught > 1'>s</template>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                                <div v-if=" past_courses.length > 3" class="past-courses-list-control" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    <strong class="past-courses-list-control__show-all text-primary">Show All Courses <i class="fas fa-chevron-right"></i></span></strong> 
                                    <strong class="past-courses-list-control__show-fewer text-primary"><i class="fas fa-chevron-left"></i> Show Fewer Courses </span></strong>
                                </div>
                            </template>
                            <template v-else>
                                {{ person_name }} does not have any past classes.
                            </template>
                        </div>
                    </div>
                    
                    <div class="order-md-last order-first col-12 col-md-8 pr-3">
                        <template v-if='current_term'>
                            <h2 class="h3 text-primary mb-4 d-none d-md-block">Academic Schedule</h2>
                            <h2 class="h5 mb-3 d-block d-md-none text-uppercase">Academic Schedule</h2>
                            <div class="classes-term-controls clearfix mb-4 mb-lg-5">
                                <h3 class="font-display d-none d-md-inline mr-3">{{ current_term.term_display }}</h3>
                                <template v-if='terms.length'>
                                    <select class="custom-select" v-model='selected_term' @change='changeTerm'>
                                        <option v-for='_term in terms' :value='_term.term_id' :selected='current_term_id == _term.term_id'>
                                            {{ _term.term_display }}
                                        </option>
                                    </select>
                                </template>
                                <button @click="openDoorSignWindow()" class="btn btn-outline-primary d-none d-md-inline" role="button">
                                    <i class="fas fa-print fa-xs"></i> Printer Friendly Door Sign
                                </button>
                            </div>
                            <hr class="hr-metaphor d-none d-sm-block">
                        </template>

                        <!-- **********************  CLASSES **************************** -->
                        <template v-if='current_term'>
                            <div>
                                <div class="mb-3 mt-4 mb-md-5 clearfix">
                                    <h3 class="d-none d-md-inline">Classes</h3>
                                    <h3 class="d-inline d-md-none font-display h5">Classes</h3>
                                    <template v-if='classes.length'>
                                        <a href="#" class="btn btn-outline-primary float-right d-none d-md-inline" role="button"><i class="fas fa-calendar-alt fa-xs"></i> Download Classes Schedule</a>    
                                    </template>
                                </div>

                                <div class="container-fluid">
  
                                    <div class="classes-table">
                                    
                                        <div class="row d-none d-sm-flex classes-table__head">
                                            <div class="col-4 pl-0">DESCRIPTION</div>
                                            <div class="col-1 pl-0">DAYS</div>
                                            <div class="col-3">TIME</div>
                                            <div class="col-2 pl-0 pl-lg-3 pl-xl-0">LOCATION</div>
                                            <div class="col-2 text-center">INFO</div>
                                        </div>
                                
                                        <template v-if='loading_classes'>
                                            <div class="row classes-table__item">
                                                <div class="col-12">
                                                    <p class="text-center">
                                                        <i class="fas fa-spinner fa-spin fa-2x"></i>
                                                    </p>
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else-if='classes.length' v-for='_class in classes'>
                                            <div class="row classes-table__item" v-for='_meeting in _class.class_meetings'>
                                                <!-- Description -->
                                                <div class="col-sm-4 col-12">
                                                    <div><strong class="classes-table__title">{{ _class.subject }} {{ _class.catalog_number }} </strong>({{ _class.class_number }})</div> 
                                                    <div class="classes-table__description">{{ _class.title }}</div>
                                                </div>
                                                <!-- Days -->
                                                <div class="col-sm-1 col-12 pl-4 pl-sm-0">
                                                    <span class="d-inline d-sm-none font-weight-bold">Days: </span>
                                                    {{ _meeting.formatted_days }}
                                                </div>
                                                <!-- Time -->
                                                <div class="col-sm-3 col-12 pr-0">
                                                    <span class="d-inline d-sm-none font-weight-bold">Time: </span>
                                                    <span class="classes-table__time">{{ _meeting.formatted_duration }}</span>
                                                </div>
                                                <!-- Location -->
                                                <div class="col-sm-2 col-12 pl-4 pl-sm-0 pl-lg-3 pl-xl-0 text-nowrap d-none d-sm-block">
                                                    <a class="classes-table__location-icon" href="javascript:void(0);" data-target="modal" data-modal="#waldoMap" data-waldo-event-trigger="click">
                                                        <i class="fas fa-map-marker-alt px-1"></i><span class="text-underline">{{ _meeting.location }}</span>
                                                    </a>
                                                </div>
                                                <!-- Info -->
                                                <div class="col-sm-2 col-12 text-sm-center text-left">
                                                    <span class="d-inline d-sm-none font-weight-bold float-left">Info: </span>
                                                    <div class="float-left float-sm-none ml-3 mt-2 ml-sm-0 mt-sm-0">
                                                        <a class="d-block d-sm-none classes-table__info-icon" href="javascript:void(0);" data-target="modal" data-modal="#waldoMap" data-waldo-event-trigger="click">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                            <span class="text-underline">View Location ({{ _meeting.location }})</span>
                                                        </a>
                                                        
                                                        
                                                        <template v-if='_class.syllabus'>
                                                            <tooltip :destroyOnXSBreakpoint="true" :tooltip-content="'View syllabus for ' + _class.subject + ' ' + _class.catalog_number">
                                                                <a class="classes-table__info-icon" :href="_class.syllabus.url" data-toggle="tooltip" data-placement="top" title="Tooltip on top" :title="'View syllabus for ' + _class.subject + ' ' + _class.catalog_number" target="_blank">
                                                                    <i class="fas fa-file-pdf"></i><span class="d-inline d-sm-none text-underline"> View syllabus for {{_class.subject}}  {{_class.catalog_number}}</span>
                                                                </a> 
                                                            </tooltip>
                                                        </template>
                                                        <template v-if='_class.bookstore_url'>
                                                            <tooltip :destroyOnXSBreakpoint="true" :tooltip-content="'View books for ' + _class.subject + ' ' + _class.catalog_number">
                                                                <a class="classes-table__info-icon" :href="_class.bookstore_url" :title="'View books for ' + _class.subject + ' ' + _class.catalog_number" target="_blank">
                                                                    <i class="fas fa-book"></i><span class="d-inline d-sm-none text-underline"> View Books for {{_class.subject}} {{_class.catalog_number}} </span>
                                                                </a>
                                                            </tooltip>
                                                        </template>
                                                        <tooltip :destroyOnXSBreakpoint="true" :tooltip-content="'Add '  + _class.subject + ' ' + _class.catalog_number + ' to your calendar'">
                                                            <a class="classes-table__info-icon" href="#">
                                                                <i class="fas fa-calendar-alt"></i><span class="d-inline d-sm-none text-underline"> Add {{_class.subject}} {{_class.catalog_number}} to your calendar</span>
                                                            </a>
                                                        </tooltip>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="row classes-table__item">
                                                <div class="col-12">
                                                    {{ person_name }} does not have any classes for the selected term.
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <template v-if='classes.length'>
                                    <a href="#" class="btn btn-outline-primary d-block d-md-none mt-3 mb-5" role="button"><i class="fas fa-calendar-alt fa-xs"></i> Download Classes Schedule</a>    
                                </template>

                            </div>
                        </template>

                        <!-- ************************  OFFICE HOURS ************************ -->

                        <template v-if='current_term'>

                            <div class="mb-3 mt-4 mb-md-5 clearfix">
                                <hr class="hr-metaphor d-none d-sm-block d-md-none">
                                <h3 class="d-none d-md-inline">Office Hours</h3>
                                <h3 class="d-inline d-md-none font-display h5">Office Hours</h3>

                                <a href="#" class="btn btn-outline-primary float-right d-none d-md-inline" role="button"><i class="fas fa-calendar-alt fa-xs"></i> Download Office Hours</a>
                            </div>

                            <!-- MOVE THE DESCRIPTION ONE TO 3 and MOVE THE REST OVER 1 -->
                            
                            <div class="container-fluid">
                                <div class="classes-table">
                                    <div class="row d-none d-sm-flex classes-table__head">
                                        <div class="col-4 pl-0">DESCRIPTION</div>
                                        <div class="col-1 pl-0">DAYS</div>
                                        <div class="col-3">TIME</div>
                                        <div class="col-2 pl-0 pl-lg-3 pl-xl-0">LOCATION</div>
                                        <div class="col-2 text-center">INFO</div>
                                    </div>
                        
                                    
                                    <template v-if='loading_officehours'>
                                        <div class="row classes-table__item">
                                            <div class="col-12">
                                                <p class="text-center">
                                                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else-if='office_hours.length'>
                                        <div class="row classes-table__item" v-for='(_office_hour,index) in office_hours'>
                                                <!-- Description -->
                                            <div class="col-sm-4 col-12">
                                                <div>
                                                    <strong class="classes-table__title">{{ _office_hour.description ? _office_hour.description : _office_hour.label }}</strong>
                                                </div> 
                                                <div class="classes-table__description">
                                                    <span v-if='_office_hour.is_byappointment && !_office_hour.is_walkin'>
                                                        Appointment Only
                                                    </span>
                                                    <span v-else-if='!_office_hour.is_byappointment && _office_hour.is_walkin'>
                                                        Walk-In
                                                    </span>
                                                    <span v-else>
                                                        Walk-In &amp; Appointment
                                                    </span>
                                                </div>
                                            </div>
                                                <!-- Days -->
                                            <div class="col-sm-1 col-12 pl-4 pl-sm-0">
                                                <span class="d-inline d-sm-none font-weight-bold">Days: </span>
                                                {{ _office_hour.formatted_days }}
                                            </div>
                                                <!-- Time -->
                                            <div class="col-sm-3 col-12 pr-0">
                                                <span class="d-inline d-sm-none font-weight-bold">Time: </span>
                                                <span v-if='!_office_hour.appointment_only' class="classes-table__time">
                                                    {{ _office_hour.duration }}
                                                </span>
                                                <template v-if='_office_hour.booking_url'>
                                                    <div>
                                                        <a :href='_office_hour.booking_url' target='_blank'>
                                                            Book an Appointment
                                                        </a>
                                                    </div>
                                                </template>
                                            </div>
                                            <!-- Location -->
                                            <div class="col-sm-2 col-12 pl-4 pl-sm-0 pl-lg-3 pl-xl-0 text-nowrap d-none d-sm-block">
                                                <template v-if='_office_hour.location'> 
                                                    <a class="classes-table__location-icon" href="javascript:void(0);" data-target="modal" data-modal="#waldoMap" data-waldo-event-trigger="click">
                                                        <i class="fas fa-map-marker-alt px-1"></i><span class="text-underline">{{ _office_hour.location }}</span>
                                                    </a>
                                                </template>
                                            </div>
                                                <!-- Info -->
                                            <div class="col-sm-2 col-12 text-sm-center text-left">
                                                <span class="d-inline d-sm-none font-weight-bold float-left mr-3">Info: </span>
                                                <tooltip :destroyOnXSBreakpoint="true" tooltip-content="Add to your calendar">
                                                    <a class="classes-table__info-icon" href="#">
                                                        <i class="fas fa-calendar-alt"></i><span class="d-inline d-sm-none text-underline"> Add to your calendar</span>
                                                    </a>
                                                </tooltip>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="row classes-table__item">
                                            <div class="col-12">
                                                {{ person_name }} has not added any office hours for the selected term.
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <template v-if='office_hours.length'>
                                <a href="#" class="btn btn-outline-primary d-block d-md-none mt-3 mb-5" role="button"><i class="fas fa-calendar-alt fa-xs"></i> Download Office Hours</a>
                            </template>

                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
<script>
import { tooltip } from './tooltip.vue'

export default {
    name: 'ProfileClasses',
    data() {
        return {
            past_courses: [],
            terms: [],
            current_term: null,
            selected_term: $("meta[name=current-term-id]").attr('content'),
            current_term_name_for_door_sign: '',
            classes: [],
            current_classes: [],
            office_hours: [],
            current_office_hours: [],
            teaching_interest: [],
            loading_all: true,
            loading_classes: false,
            loading_officehours: false
        }
    },
    computed: {
        api_url: function() {
            return $("html").attr('data-api-url');
        },
        faculty_url: function() {
            return $("meta[name=faculty-url]").attr('content');
        },
        person_name: function() {
            return $("meta[name=person-name]").attr('content');
        },
        person_uri: function() {
            return $("meta[name=person-uri]").attr('content');
        },
        faculty_profile_url: function() {
            return this.faculty_url + this.person_uri;
        },
        current_term_id: function() {
            return $("meta[name=current-term-id]").attr('content');
        },
        person_email: function() {
            return $("meta[name=person-email]").attr('content');
        }
    },
    methods: {
        changeTerm: function() {
            // we are now loading the classes and office hours
            this.loading_classes = true;
            this.loading_officehours = true;

            // clear out the classes and office hours
            this.classes = [];
            this.office_hours = [];

            // apply the current term
            this.current_term = this.terms.filter((term) => {
                return term.term_id == this.selected_term;
            }).pop();

            // make the Axios calls concurrently and wait for all of them to return
            // before applying the reactive data
            axios.all([this.loadCurrentClasses(), this.loadOfficeHours()])
                .then(axios.spread((current_classes, office_hours) => {
                    // apply the current classes
                    var current_class_data = current_classes.data;
                    this.classes = current_class_data;

                    // apply the office hours
                    var office_hours_data = office_hours.data;
                    this.office_hours = office_hours_data;

                    // we have finished loading classes and office hours
                    this.loading_classes = false;
                    this.loading_officehours = false;
                }))
                .then(() => {
                    // allow for the map to be used for location information
                    Waldo.setAllWaldoListeners();
                });
        },
        loadCurrentClasses: function() {
            return axios.get(
                'people/' + this.person_uri + '/classes',
                {
                    baseURL: this.api_url,
                    params: {
                        term_id: this.selected_term
                    }
                }
            );
        },
        loadTeachingInterests: function() {
            return axios.get(
                'interests/academic?email=' + this.person_email,
                {
                    baseURL: $("meta[name=affinity-url]").attr('content'),
                    params: {
                        email: this.person_email
                    }
                }
            );
        },
        loadOfficeHours: function() {
            return axios.get(
                'people/' + this.person_uri + '/office-hours',
                {
                    baseURL: this.api_url,
                    params: {
                        term_id: this.selected_term
                    }
                }
            );
        },
        loadPastCourses: function() {
            return axios.get(
                'people/' + this.person_uri + '/classes/history',
                {
                    baseURL: this.api_url
                }
            );
        },
        loadTerms: function() {
            return axios.get(
                'collections/terms',
                {
                    baseURL: this.api_url
                }
            );
        },
        openDoorSignWindow: function () {
            var windowObjectReference;
            var strWindowFeatures = "menubar=no,toolbar=no,personalbar=no,resizable=yes,scrollbars=yes,status=no,titlebar=no,height=600,width=700,centerscreen=yes";
            var appUrl = document.querySelector("html").getAttribute("data-url") 

            windowObjectReference = window.open(appUrl + "/printer-friendly-door-sign", "DoorSign", strWindowFeatures);
            windowObjectReference.current_classes = this.current_classes;
            windowObjectReference.current_office_hours = this.current_office_hours;
            windowObjectReference.person_name = this.person_name
            windowObjectReference.person_email = this.person_email
            windowObjectReference.term = this.current_term_name_for_door_sign
        }
    },
    mounted() {
        // make the Axios calls concurrently and wait for all of them to return
        // before applying the reactive data
        axios.all([this.loadCurrentClasses(), this.loadOfficeHours(), this.loadPastCourses(), this.loadTerms(), this.loadTeachingInterests()])
            .then(axios.spread((current_classes, office_hours, past_courses, terms, teaching_interests) => {
                // apply the current classes
                var current_class_data = current_classes.data;
                this.classes = current_class_data;
                this.current_classes = current_class_data;

                // apply the office hours
                var office_hours_data = office_hours.data;
                this.office_hours = office_hours_data;
                this.current_office_hours = office_hours_data;

                // apply the past courses
                var past_courses_data = past_courses.data;
                this.past_courses = past_courses_data;

                // apply the set of terms
                var term_data = terms.data;
                this.terms = term_data.terms;
                this.current_term = term_data.current;
                this.current_term_name_for_door_sign  = term_data.current.term_display;

                // apply the set of teaching interests
                var teaching_interests_data = teaching_interests.data.interests;
                this.teaching_interest = teaching_interests_data;

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
