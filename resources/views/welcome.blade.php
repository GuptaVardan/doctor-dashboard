<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doctor's Appointment</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .carousel-item img{
            height: 1400px;
            object-fit: cover;
        }
        .modal, .btn, .card-title, .card-text {
            font-size: 20px;
        }
    </style>
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <span class="navbar-brand" style="font-size: 30px">To consult a doctor, click "Consult me" button under that Doctor's Name</span>
            <a class="navbar-brand" href="/doctor/registration" style="font-size: 30px">Create a new doctor's account</a>
            <a class="navbar-brand" href="/doctor/login" style="font-size: 30px">Login to your doctor's dashboard</a>
        </div>
    </nav>
    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('assets/intro.jpg') }}" class="d-block w-100" alt="Loading..">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/treat.jpg') }}" class="d-block w-100 h-20" alt="Loading..">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/doctors.jpg') }}" class="d-block w-100 h-20" alt="Loading..">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <h1 style="text-align: center">Our Doctors</h1>
    <div class="container my-5">
        <div class="row">
            @foreach($doctors as $doctor)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('images/' . $doctor->image) }}" class="card-img-top" alt="{{ $doctor->name }} style="height=400px">
                        <div class="card-body">
                            <h5 class="card-title">{{ $doctor->name }}</h5>
                            <p class="card-text">Specialization: {{ $doctor->spl }}</p>
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#consultModal" data-doctor-name="{{ $doctor->name }}">Consult me</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="consultModal" tabindex="-1" aria-labelledby="consultModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="consultModalLabel">Consult Doctor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="warning">
                        <h3>Instructions:</h3>
                        <ul>
                            <li>Fill the form correctly.</li>
                            <li>Provide a valid email address</li>
                            <li>Name must contain letters and spaces only</li>
                            <li>Specify a timing (up to 255 characters).</li>
                            <li>Timing must contain date and time clearly.</li>
                            <li>Violating any of the instruction will result in rejection of your appointment.</li>
                            <li>We won't be responsible if your appointment is rejected.</li>
                        </ul>
                    </div>
                    <form method="POST" action="{{ route('save.appointment') }}">
                        @csrf
                        <input type="hidden" name="doctor_name" id="doctorName">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputName1" class="form-label">Name of the Patient</label>
                            <input type="text" class="form-control" id="exampleInputName1" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputTime1" class="form-label">Timing</label>
                            <input type="text" class="form-control" id="exampleInputTime1" name="timing" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="readyToGo" required>
                            <label class="form-check-label" for="readyToGo">I have read the instructions carefully. I will take all responsibility if my appointment is rejected</label>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveChangesButton">Save changes</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const consultModal = document.getElementById('consultModal');
            consultModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const doctorName = button.getAttribute('data-doctor-name');
                const modalTitle = consultModal.querySelector('.modal-title');
                const doctorNameInput = consultModal.querySelector('#doctorName');

                modalTitle.textContent = `Consult Doctor ${doctorName}`;
                doctorNameInput.value = doctorName;
            });
        });
    </script>    
</body>

</html>
