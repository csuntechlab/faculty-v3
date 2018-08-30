<template>
    <div id="classes">
        <div class="container pt-4">
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
                    <template v-if='past_courses.length'>             
                        <div class="order-last order-md-first col-md-4 pt-5 pt-md-0">
                            <div class="FAC-pastCourses">
                                <h6>PAST COURSES</h6>
                                <ul>
                                    <template v-for='_past_course in past_courses'>
                                        <li class="pb-4 pt-0 pt-md-3 float-md-none float-left pr-4 FAC-pastCourses-width">
                                            <strong>{{ _past_course.subject }} {{ _past_course.catalog_number }}</strong>
                                            <div>{{ _past_course.title }}</div>
                                            <div>Last Offered {{ _past_course.last_taught }}</div>
                                            <div v-if='_past_course.times_taught > 1'>
                                                Taught {{ _past_course.times_taught }} terms
                                            </div>
                                            <div v-else>
                                                Taught 1 term
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </template>
                    <div class="order-md-last order-first col-12 col-md-8 pr-3">
                        <template v-if='current_term'>
                            <h2>My Academic Schedule</h2>
                            <div>
                                <h3 class="list-inline-item">{{ current_term.term_display }}</h3>
                                <a :href="faculty_profile_url + '/printout'" class="btn btn-outline-primary" role="button">
                                    <i class="fas fa-print fa-xs"></i> Printer Friendly Door Sign
                                </a>
                                <template v-if='terms.length'>
                                    <select class="custom-select" id="term_select" v-model='selected_term' @change='changeTerm'>
                                        <option v-for='_term in terms' :value='_term.term_id' :selected='current_term_id == _term.term_id'>
                                            {{ _term.term_display }}
                                        </option>
                                        <i class="fas fa-caret-down"></i>
                                    </select>
                                </template>
                            </div>
                            <hr class="FAC-semester-divider">
                        </template>

                        <!-- **********************  CLASSES **************************** -->
                        <template v-if='current_term'>
                            <template v-if='classes.length'>
                                <div class="FAC-downloadBtn">
                                    <div class="FAC-downloadBtn__orientation">
                                        <a href="#" class="btn btn-outline-primary mt-2" role="button"><i class="fas fa-calendar-alt fa-xs"></i> Download Classes Schedule</a>
                                    </div>
                                </div>
                            </template>
                            <div>
                                <h3 class="list-inline-item">Classes</h3>
                                <!-- <div class="container">
                                    <div class="row d-none d-md-inline">
                                        <div class="col-4 list-inline-item pl-0">DESCRIPTION</div>
                                        <div class="col-1 list-inline-item pl-0">DAYS</div>
                                        <div class="col-3 list-inline-item ">TIME</div>
                                        <div class="col-2 list-inline-item ">LOCATION</div>
                                        <div class="col-2 list-inline-item text-center">INFO</div>
                                    </div> -->

                                    <div class="container">
                                    <div class="row d-none d-sm-flex">
                                        <div class="col-4 pl-0">DESCRIPTION</div>
                                        <div class="col-1 pl-0">DAYS</div>
                                        <div class="col-3">TIME</div>
                                        <div class="col-2">LOCATION</div>
                                        <div class="col-2 text-center">INFO</div>
                                    </div>
                                
                                    <template v-if='classes.length' v-for='_class in classes'>
                                        <div class="row FAC-class-wrapper py-3" v-for='_meeting in _class.class_meetings'>
                                            <!-- Description -->
                                            <div class="col-sm-4 col-12">
                                                <div class="FAC-font-size"><strong>{{ _class.subject }} {{ _class.catalog_number }} </strong>({{ _class.class_number }})</div> 
                                                <div class="FAC-font-size font-italic">{{ _class.title }}</div>
                                            </div>
                                            <!-- Days -->
                                            <div class="FAC-font-size col-sm-1 col-12 pl-3 pl-sm-0 pr-0">
                                            {{ _meeting.formatted_days }}
                                            </div>
                                            <!-- Time -->
                                            <div class="FAC-font-size col-sm-3 col-12 pr-0">
                                            {{ _meeting.formatted_duration }}
                                            </div>
                                            <!-- Location -->
                                            <div class="FAC-font-size col-sm-2 col-12 pl-2 pr-0 text-nowrap">
                                                <a href="#"><i class="fas fa-map-marker-alt px-1 FAC-location-icons"></i>{{ _meeting.location }}</a>
                                            </div>
                                            <!-- Info -->
                                            <div class="FAC-font-size col-sm-2 col-12 text-sm-center text-left">
                                                <template v-if='_class.syllabus'>
                                                    <a :href="_class.syllabus.url" :title="'View syllabus for ' + _class.subject + ' ' + _class.catalog_number" target="_blank">
                                                        <i class="fas fa-file-pdf FAC-info-icons"></i>
                                                    </a>
                                                </template>
                                                <template v-if='_class.bookstore_url'>
                                                    <a :href="_class.bookstore_url" :title="'View books for ' + _class.subject + ' ' + _class.catalog_number" target="_blank">
                                                        <i class="fas fa-book FAC-info-icons"></i>
                                                    </a>
                                                </template>
                                                <i class="fas fa-calendar-alt FAC-info-icons "></i>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="row FAC-class-wrapper py-3">
                                            <div class="col-12 FAC-font-size">
                                                {{ person_name }} does not have any classes for the selected term.
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- ************************  OFFICE HOURS ************************ -->

                        <template v-if='current_term'>
                            <template v-if='office_hours.length'>
                                <div class="FAC-downloadBtn">
                                    <div class="FAC-downloadBtn__orientation">
                                        <a href="#" class="btn btn-outline-primary mt-4" role="button"><i class="fas fa-calendar-alt fa-xs"></i> Download Office Hours</a>
                                    </div>
                                </div>
                            </template>
                            <div>
                                <!-- MOVE THE DESCRIPTION ONE TO 3 and MOVE THE REST OVER 1 -->
                                <h3 class="list-inline-item">Office Hours</h3>
                                <div class="container">
                                    <div class="row d-none d-sm-flex">
                                        <div class="col-4 pl-0">DESCRIPTION</div>
                                        <div class="col-1 pl-0">DAYS</div>
                                        <div class="col-3">TIME</div>
                                        <div class="col-2">LOCATION</div>
                                        <div class="col-2 text-center">iCAL</div>
                                    </div>
                                </div>

                                
                                <div class="container FAC-officeHours-wrapper">
                                    <template v-if='office_hours.length'>
                                        <div class="row py-3" :class="{'FAC-darkStriped': index % 2 == 0, 'FAC-whiteStriped': index % 2 != 0}" v-for='(_office_hour,index) in office_hours'>
                                             <!-- Description -->
                                            <div class="col-sm-4 col-12">
                                                <div class="FAC-font-size">
                                                    <strong>{{ _office_hour.description ? _office_hour.description : _office_hour.label }}</strong>
                                                </div> 
                                                <div class="FAC-font-size font-italic">
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
                                            <div class="FAC-font-size col-sm-1 col-12 pl-3 pl-sm-0 pr-0">
                                                {{ _office_hour.formatted_days }}
                                            </div>
                                             <!-- Time -->
                                            <div class="FAC-font-size col-sm-3 col-12 pr-0">
                                                <div v-if='!_office_hour.appointment_only'>
                                                    {{ _office_hour.duration }}
                                                </div>
                                                <template v-if='_office_hour.booking_url'>
                                                    <div>
                                                        <a :href='_office_hour.booking_url' target='_blank'>
                                                            Book an Appointment
                                                        </a>
                                                    </div>
                                                </template>
                                            </div>
                                            <!-- Location -->
                                            <div class="FAC-font-size col-sm-2 col-12 pl-2 pr-0 text-nowrap">
                                                <template v-if='_office_hour.location'> 
                                                    <a href="#">
                                                        <i class="fas fa-map-marker-alt px-1 FAC-location-icons"></i>{{ _office_hour.location }}
                                                    </a>
                                                </template>
                                            </div>
                                             <!-- Info -->
                                            <div class="FAC-font-size col-sm-2 col-12 text-sm-center text-left">
                                                <i class="fas fa-calendar-alt FAC-info-icons"></i>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="row FAC-darkStriped py-3">
                                            <div class="col-12">
                                                {{ person_name }} has not added any office hours for the selected term.
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
    name: 'ProfileClasses',
    data() {
        return {
            past_courses: [],
            terms: [],
            current_term: null,
            selected_term: $("meta[name=current-term-id]").attr('content'),
            classes: [],
            office_hours: [],
            loading_all: true,
            loading_classes: true,
            loading_officehours: true
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
        }
    },
    methods: {
        changeTerm: function() {
            // we are now loading the classes and office hours
            this.loading_classes = true;
            this.loading_officehours = true;

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
                }));
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
        }
    },
    mounted() {
        // make the Axios calls concurrently and wait for all of them to return
        // before applying the reactive data
        axios.all([this.loadCurrentClasses(), this.loadOfficeHours(), this.loadPastCourses(), this.loadTerms()])
            .then(axios.spread((current_classes, office_hours, past_courses, terms) => {
                // apply the current classes
                var current_class_data = current_classes.data;
                this.classes = current_class_data;

                // apply the office hours
                var office_hours_data = office_hours.data;
                this.office_hours = office_hours_data;

                // apply the past courses
                var past_courses_data = past_courses.data;
                this.past_courses = past_courses_data;

                // apply the set of terms
                var term_data = terms.data;
                this.terms = term_data.terms;
                this.current_term = term_data.current;

                // we have finished loading everything
                this.loading_all = false;
            }));
    }
}
</script>
