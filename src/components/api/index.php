<?php

class Database
{
    

    private static $instance = null;
    private $db;
   

    private function __construct()
    {
        $this->db = json_decode(file_get_contents('Data.json', FILE_USE_INCLUDE_PATH), true);
        $this->db = $this->db['Report_Entry'];

        
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getDB()
    {
        return $this->db;
    }

    public function getUnique($column)
    {
        return array_unique(array_column($this->db, $column));
    }
}


class Course
{
    public string $courseSubjects = '';
    public string $courseListing = '';
    public int $enrollmentCount = 0;
    public string $campusLocations = '';
    public string $instructionalFormat = '';
    public string $courseNumber = '';
    public string $courseDescription = '';
    public string $endDate = '';
    public string $deliveryMode = '';
    public array $requirements = [];
    public array $instructors = [];
    public string $units = '';
    public string $academicLevel = '';
    public string $meetingPattern = '';
    public string $academicPeriod = '';
    public string $startDate = '';
    public int $sectionCapacity = 0;
    public string $location = '';

    public function __construct($courseSubjects = '', $courseListing = '', $enrollmentCount = 0, $campusLocations = '', $instructionalFormat = '', $courseNumber = '', $courseDescription = '', $endDate = '', $deliveryMode = '', $requirements = [], $instructors = [], $units = '', $academicLevel = '', $meetingPattern = '', $academicPeriod = '', $startDate = '', $sectionCapacity = 0, $location = '')
    {
        $this->courseSubjects = $courseSubjects ?? 'N/A';
        $this->courseListing = $courseListing ?? 'N/A';
        $this->enrollmentCount = $enrollmentCount ?? 0;
        $this->campusLocations = $campusLocations ?? 'N/A';
        $this->instructionalFormat = $instructionalFormat ?? 'N/A';
        $this->courseNumber = $courseNumber ?? 'N/A';
        $this->courseDescription = $courseDescription ?? 'N/A';
        $this->endDate = $endDate ?? 'N/A';
        $this->deliveryMode = $deliveryMode ?? 'N/A';

        try {
            if (!is_array($requirements)) {
                $requirements = [$requirements];
            } else {
                foreach ($requirements as $requirement) {
                    if (!is_string($requirement)) {
                        throw new Exception('Requirements must be an array of strings.');
                    }
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $this->requirements = $requirements;

        try {
            if (!is_array($instructors)) {
                $instructors = [$instructors];
            } else {
                foreach ($instructors as $instructor) {
                    if (!is_string($instructor) && !is_array($instructor) || empty($instructor)) {
                        $instructors = ['N/A'];
                    }
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $this->instructors = $instructors;

        $this->units = $units;
        $this->academicLevel = $academicLevel;
        $this->meetingPattern = $meetingPattern;
        $this->academicPeriod = $academicPeriod;
        $this->startDate = $startDate;
        $this->sectionCapacity = $sectionCapacity;
        $this->location = $location;
    }

    public function displayCourse()
    {
        echo '<h1>' . $this->courseSubjects . '</h1>';
        echo '<p>' . $this->enrollmentCount . '</p>';
        echo '<h2>' . $this->courseListing . '</h2>';
        echo '<p>' . $this->enrollmentCount . '</p>';
        echo '<p>' . $this->campusLocations . '</p>';
        echo '<p>' . $this->instructionalFormat . '</p>';
        echo '<p>' . $this->courseNumber . '</p>';
        echo '<p>' . $this->courseDescription . '</p>';
        echo '<p>' . $this->endDate . '</p>';
        echo '<p>' . $this->deliveryMode . '</p>';
        // Requirements starts with a string
        // Student has satisfied any of the following:
        // [Institution has received a(n) Accuplacer Next Generation Reading test result with a(n) Reading score less than or equal to 251.]
        echo '<p>' . implode(', ', $this->requirements) . '</p>';
        echo '<p>' . implode(', ', $this->instructors) . '</p>';
        echo '<p>' . $this->units . '</p>';
        echo '<p>' . $this->academicLevel . '</p>';
        echo '<p>' . $this->meetingPattern . '</p>';
        echo '<p>' . $this->academicPeriod . '</p>';
        echo '<p>' . $this->startDate . '</p>';
        echo '<p>' . $this->sectionCapacity . '</p>';
        echo '<p>' . $this->location . '</p>';
   }
}

class CourseListing
{
    public array $courses = [];
    private $db;

    public function __construct($courses = [])
    {
        $this->db = Database::getInstance();
        $this->courses = $this->db->getDB();
    }
}

$courseListing = new CourseListing();
$courseListing = $courseListing->courses;

// print_r($courseListing);
// 
// foreach ($courseListing as $course) {
//     $course = new Course($course['Course_Subjects'], $course['Course_Listing'], $course['Enrollment_Count'], $course['Campus_Locations'] ?? '', $course['Instructional_Format'], $course['Section_Listings_group'][0]['Course_Number'], $course['Course_Description'], $course['End_Date'], $course['Delivery_Mode'], $course['Requirements'], $course['Instructors'] ?? [], $course['Units'] ?? '', $course['Academic_Level'], $course['Meeting_Pattern'] ?? '', $course['Academic_Period'], $course['Start_Date'], $course['Section_Capacity'], $course['Location'] ?? '');
// 
//     echo '<pre>';
//     print_r($course->displayCourse());
//     echo '</pre>';
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Listings</title>

    <!-- Custom CSS -->
    <link href="public/css/style.css" rel="stylesheet" type="text/css">

    <!-- Core Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- Vue.js -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/vue-router@4"></script>
</head>

<body>
    <div id="app" class="m-0 p-0">

        <nav class="navbar bg-body-tertiary sticky-top w-100">
            <div class="container-fluid w-100">
                <form class="d-flex flex-column justify-content-evenly align-items-middle w-100" role="search" @submit.prevent="handleSubmit">

                    <div class="container-fluid d-flex flex-row">
                        <input v-model="searchCriteria.text" class="form-control me-2" type="search" placeholder="Search Courses" aria-label="Search">
                        <button class="btn btn-outline-success me-2" type="submit">Search</button>

                        <select v-model="searchCriteria.academicPeriod" class="form-select me-2" aria-label="Academic Period">
                            <option value="" selected>Academic Period</option>
                            <option v-for="period in academicPeriods" :value="period">{{ period }}</option>
                        </select>

                        <select v-model="searchCriteria.academicLevel" class="form-select me-2" aria-label="Academic Level">
                            <option value="" selected>Academic Level</option>
                            <option v-for="level in academicLevels" :value="level">{{ level }}</option>
                        </select>

                    </div>

                    <div class="container-fluid d-flex flex-row mt-3">
                        <h6 class="text-dark text-uppercase">Search Criteria: </h6>
                        <span v-if="searchCriteria.text !== '' || searchCriteria.academicPeriod !== '' || searchCriteria.academicLevel !== ''" class="badge text-wrap text-dark ms-2">
                            {{ searchCriteria.text }}
                        </span>
                        <span v-if="searchCriteria.academicPeriod !== ''" class="badge text-wrap text-dark ms-2">
                            {{ searchCriteria.academicPeriod }}
                        </span>
                        <span v-if="searchCriteria.academicLevel !== ''" class="badge text-wrap text-dark ms-2">
                            {{ searchCriteria.academicLevel }}
                        </span>
                    </div>
                </form>
            </div>
        </nav>

        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center">Course Listings</h1>
                </div>
            </div>
            <div class="row" v-if="filteredCourses.length === 0">
                <div class="col-12">
                    <p class="text-center">No courses found matching the criteria.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark fs-6 sticky-top">
                            <tr class="text-center fs-6">
                                <!-- <th scope="col">Course Subjects</th> -->
                                <th scope="col">Course Listing</th>
                                <!-- <th scope="col">Enrollment Count</th> -->
                                <!-- <th scope="col">Campus Locations</th>
                                <th scope="col">Instructional Format</th>
                                <th scope="col">Course Number</th>
                                <th scope="col">Course Description</th>
                                <th scope="col">Delivery Mode</th>
                                <-- <th scope="col">Requirements</th> -->
                                <!-- <th scope="col">Instructors</th> -->
                                <th scope="col">Units</th>
                                <th scope="col">Academic Level</th>
                                <!-- <th scope="col">Meeting Pattern</th> -->
                                <th scope="col">Academic Period</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <!-- <th scope="col">Section Capacity</th> -->
                                <!-- <th scope="col">Location</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="course in courses" @click="openCourseModal(course)">
                                <!-- <td class="text-center"> {{ course['Course_Subjects'] }}</td> -->
                                <td> {{ course['Course_Listing'] }}</td>
                                <!-- <td> {{ course['Enrollment_Count'] }}</td>
                                <td> {{ course['Campus_Locations'] }}</td>
                                <td> {{ course['Instructional_Format'] }}</td>
                                <td> {{ course['Section_Listings_group'][0]['Course_Number'] }}</td>
                                <td> {{ course['Course_Description'] }}</td>
                                <td> {{ course['Delivery_Mode'] }}</td>
                                <td> {{ course['Requirements'] }}</td>
                                <td> {{ course['Instructors'] }}</td> -->
                                <td class="text-center"> {{ course['Units_and_Unit_Type'] }}</td>
                                <td class="text-center"> {{ course['Academic_Level'] }}</td>
                                <!-- <td> {{ course['Meeting_Pattern'] }}</td> -->
                                <td> {{ course['Academic_Period'] }}</td>
                                <td> {{ course['Start_Date'] }}</td>
                                <td> {{ course['End_Date'] }}</td>
                                <!-- <td> {{ course['Section_Capacity'] }}</td>
                                <td> {{ course['Location'] }}</td>
                                  -->
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="courseModalLabel"></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-left">
                            <strong>
                                {{ selectedCourse['Course_Listing'] }}
                            </strong>
                        </p>
                        <p><strong>Subjects:</strong> {{ selectedCourse.Course_Subjects }}</p>
                        <p><strong>Course Number:</strong> Course Number </p>

                        <p><strong>Units:</strong> {{ selectedCourse.Units_and_Unit_Type }}</p>

                        <p><strong>Description:</strong> {{ selectedCourse.Course_Description }}</p>
                        <p><strong>Enrollment Count:</strong> {{ selectedCourse.Enrollment_Count }}</p>
                        <p><strong>Section Capacity:</strong> {{ selectedCourse.Section_Capacity }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="pagination-controls container-fluid w-100 d-flex justify-content-center align-items-center">
            <button @click="changePage(1)" :disabled="currentPage === 1">First</button>
            <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1">Previous</button>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <button @click="changePage(currentPage + 1)" :disabled="currentPage >= totalPages">Next</button>
            <button @click="changePage(totalPages)" :disabled="currentPage >= totalPages">Last</button>
        </div>


    </div>

    <!-- Custom Vue JS -->
    <script src=" public/js/app.js"></script>

    <!-- Core Bootstrap JS -->
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>