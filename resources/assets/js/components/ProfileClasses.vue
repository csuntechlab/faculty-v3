<template>
    <div id="classes">
        <div class="container pt-4">
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
                    <h2>My Academic Schedule</h2>
                    <div>
                        <h3 class="list-inline-item">Fall 2018</h3>
                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-print fa-xs"></i> Printer Friendly Door Sign</button>
                        <!-- <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Choose Semester <span class="sr-only">Toggle Dropdown</span></button> -->
                        <!-- <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div> -->
                        <select class="custom-select" id="inputGroupSelect01">
                            <option selected>Choose Semester</option> 
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <i class="fas fa-caret-down"></i>
                        </select>
                    </div>
                    
                    <hr class="FAC-semester-divider">

                    <!-- **********************  CLASSES **************************** -->
                            <div class="FAC-downloadBtn">
                                <div class="FAC-downloadBtn__orientation">
                                    <button type="button" class="btn btn-outline-primary mt-2"><i class="fas fa-calendar-alt fa-xs"></i> Download Classes Schedule</button>
                                </div>
                            </div>
                    
                    
                    

                    <div><h3 class="list-inline-item">Classes</h3>
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
                        

                            <div class="row FAC-class-wrapper py-3">
                                <!-- Description -->
                                <div class="col-sm-4 col-12">
                                    <div class="FAC-font-size"><strong>CIT 160 </strong>(20433)</div> 
                                    <div class="FAC-font-size font-italic">Internet Technologies</div>
                                </div>
                                <!-- Days -->
                                <div class="FAC-font-size col-sm-1 col-12 pl-3 pl-sm-0 pr-0">M W</div>
                                <!-- Time -->
                                <div class="FAC-font-size col-sm-3 col-12 pr-0">1:00 p.m - 1:50 p.m.</div>
                                <!-- Location -->
                                <div class="FAC-font-size col-sm-2 col-12 pl-2 pr-0 text-nowrap"><a href="#"><i class="fas fa-map-marker-alt px-1 FAC-location-icons"></i>JD3520</a></div>
                                <!-- Info -->
                                <div class="FAC-font-size col-sm-2 col-12 text-sm-center text-left">
                                    <i class="fas fa-file-pdf FAC-info-icons"></i>
                                    <i class="fas fa-book FAC-info-icons"></i>
                                    <i class="fas fa-calendar-alt FAC-info-icons "></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ************************  OFFICE HOURS ************************ -->

                    
                    <div class="FAC-downloadBtn">
                        <div class="FAC-downloadBtn__orientation">
                            <button type="button" class="btn btn-outline-primary mt-4"><i class="fas fa-calendar-alt fa-xs"></i> Download Office Hours</button>
                        </div>
                    </div>
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
                            <div class="row FAC-darkStriped py-3">
                                 <!-- Description -->
                                <div class="col-sm-4 col-12">
                                    <div class="FAC-font-size"><strong>General Office Hours</strong></div> 
                                    <div class="FAC-font-size font-italic">Walk-In & Appointment</div>
                                </div>
                                 <!-- Days -->
                                <div class="FAC-font-size col-sm-1 col-12 pl-3 pl-sm-0 pr-0">M T</div>
                                 <!-- Time -->
                                <div class="FAC-font-size col-sm-3 col-12 pr-0">
                                    <div>1:00 p.m - 1:50 p.m.</div> 
                                    <div><a href="#">Book an Appointment</a></div>
                                </div>
                                 <!-- Location -->
                                <div class="FAC-font-size col-sm-2 col-12 pl-2 pr-0 text-nowrap"><a href="#"><i class="fas fa-map-marker-alt px-1 FAC-location-icons"></i>META+LAB</a></div>
                                 <!-- Info -->
                                <div class="FAC-font-size col-sm-2 col-12 text-sm-center text-left">
                                    <i class="fas fa-calendar-alt FAC-info-icons"></i>
                                </div>
                            </div>




                            <div class="row FAC-whiteStriped py-3">
                                <!-- Description -->
                                <div class="col-sm-4 col-12">
                                    <div class="FAC-font-size"><strong>Graduate Advisement</strong></div> 
                                    <div class="FAC-font-size font-italic">Appointment Only</div>
                                </div>
                                 <!-- Days -->
                                <div class="FAC-font-size col-sm-1 col-12 pl-3 pl-sm-0 pr-0">T R</div>
                                 <!-- Time -->
                                <div class="FAC-font-size col-sm-3 col-12 pr-0">
                                    <div><a href="#">Book an Appointment</a></div>
                                </div>
                                 <!-- Location -->
                                <div class="FAC-font-size col-sm-2 col-12 pl-2 pr-0 text-nowrap"><a href="#"><i class="fas fa-map-marker-alt px-1 FAC-location-icons"></i>JD3520</a></div>
                                 <!-- Info -->
                                <div class="FAC-font-size col-sm-2 col-12 text-sm-center text-left">
                                    <i class="fas fa-calendar-alt FAC-info-icons"></i>
                                </div>
                            </div>



                            <div class="row FAC-darkStriped py-3">
                                <!-- Description -->
                                <div class="col-sm-4 col-12">
                                    <div class="FAC-font-size"><strong>CIT 160</strong></div> 
                                    <div class="FAC-font-size font-italic">Walk-In & Appointment</div>
                                </div>
                                 <!-- Days -->
                                <div class="FAC-font-size col-sm-1 col-12 pl-3 pl-sm-0 pr-0">W</div>
                                 <!-- Time -->
                                <div class="FAC-font-size col-sm-3 col-12 pr-0">
                                    <div>2:00 p.m - 3:00 p.m.</div> 
                                    <div><a href="#">Request an Appointment</a></div>
                                </div>
                                 <!-- Location -->
                                <div class="FAC-font-size col-sm-2 col-12 pl-2 pr-0 text-nowrap"><a href="#"><i class="fas fa-map-marker-alt px-1 FAC-location-icons"></i>META+LAB</a></div>
                                 <!-- Info -->
                                <div class="FAC-font-size col-sm-2 col-12 text-sm-center text-left">
                                    <i class="fas fa-calendar-alt FAC-info-icons"></i>
                                </div>
                            </div>



                            <div class="row FAC-whiteStriped py-3">
                                <!-- Description -->
                                <div class="col-sm-4 col-12">
                                    <div class="FAC-font-size"><strong>Appointment Only</strong></div> 
                                    <div class="FAC-font-size font-italic">Walk-In & Appointment</div>
                                </div>
                                 <!-- Days -->
                                <div class="FAC-font-size col-sm-1 col-12 pl-3 pl-sm-0 pr-0">F</div>
                                 <!-- Time -->
                                <div class="FAC-font-size col-sm-3 col-12 pr-0">
                                    <div>1:00 p.m - 1:50 p.m.</div> 
                                    <div><a href="#">Book an Appointment</a></div>
                                </div>
                                 <!-- Location -->
                                <div class="FAC-font-size col-sm-2 col-12 pl-2 pr-0 text-nowrap"><a href="#"><i class="fas fa-map-marker-alt px-1 FAC-location-icons"></i>META+LAB</a></div>
                                 <!-- Info -->
                                <div class="FAC-font-size col-sm-2 col-12 text-sm-center text-left">
                                    <i class="fas fa-calendar-alt FAC-info-icons"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ProfileClasses',
    data() {
        return {
            past_courses: []
        }
    },
    methods: {
        loadPastCourses: function() {
            return axios.get(
                'people/' + $("meta[name=person-uri]").attr('content') + '/classes/history',
                {
                    baseURL: $('html').attr('data-api-url')
                }
            );
        }
    },
    mounted() {
        // make the Axios calls concurrently and wait for all of them to return
        // before applying the reactive data
        axios.all([this.loadPastCourses()])
            .then(axios.spread((past_courses) => {
                // apply the past courses
                var past_courses_data = past_courses.data;
                this.past_courses = past_courses_data;
            }));
    }
}
</script>
