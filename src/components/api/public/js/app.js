const { createApp } = Vue;

const app = createApp({
    data() {
        return {
            searchCriteria: {
                text: '',
                academicPeriod: '',
                academicLevel: '',
            },
            allCourses: [],
            courses: [],
            currentPage: 1,
            itemsPerPage: 50,

            academicPeriods: [],
            academicLevels: [],

            selectedCourse: {},
        };
    },

    computed: {
        filteredCourses() {
            return this.allCourses.filter(course => {
                return (!this.searchCriteria.text || course['Course_Listing'].toLowerCase().includes(this.searchCriteria.text.toLowerCase())) &&
                    (!this.searchCriteria.academicPeriod || course['Academic_Period'].toLowerCase() === this.searchCriteria.academicPeriod.toLowerCase()) &&
                    (!this.searchCriteria.academicLevel || course['Academic_Level'].toLowerCase() === this.searchCriteria.academicLevel.toLowerCase());
            });
        },

        totalPages() {
            return Math.ceil(this.filteredCourses.length / this.itemsPerPage);
        },

        paginatedCourses() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.filteredCourses.slice(start, end);
        }
    },

    watch: {
        searchCriteria: {
            handler() {
                this.currentPage = 1;
                this.fetchCourses();
            },

            deep: true
        }
    },

    methods: {
        fetchCourses() {
            const url = new URL('http://localhost:8005/courses.json');
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    this.allCourses = data['Report_Entry'];
                    this.setUniqueFilters();
                    this.courses = this.paginatedCourses;
                })
                .catch(error => console.error('Error Fetching Courses: ', error));
        },

        handleSubmit() {
            this.currentPage = 1;
            this.fetchCourses();
        },

        changePage(page) {
            this.currentPage = page;
            this.courses = this.paginatedCourses;
        },

        setUniqueFilters() {
            const periods = new Set();
            const levels = new Set();
            this.allCourses.forEach(course => {
                periods.add(course['Academic_Period']);
                levels.add(course['Academic_Level']);
            });

            this.academicPeriods = Array.from(periods);
            this.academicLevels = Array.from(levels);
        },

        openCourseModal(course) {

            this.selectedCourse = course;
            const modal = new bootstrap.Modal(document.getElementById('courseModal'));
            modal.show();
            console.log(course);
        }
    },

    mounted() {
        this.fetchCourses();
    }
});

app.mount('#app');