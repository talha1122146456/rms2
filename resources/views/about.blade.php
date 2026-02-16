<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Talha Zeeshan - Full Stack Developer</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@400;500;600&family=Great+Vibes&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #0d6efd;
      --text: #ffffff;
      --bg: #000;
      --glow-color: #00bfff;
    }

    body {
      margin: 0;
      padding: 0;
      background-color: var(--bg);
      color: var(--text);
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }

    /* 🔹 INTRO SECTION */
    .intro-section {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 0;
    }

    .intro-text h1 {
      font-family: 'Playfair Display', serif;
      font-size: 3.2rem;
      font-weight: 600;
      line-height: 1.2;
      color: var(--text);
      letter-spacing: 0.5px;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 1s ease forwards, textGlow 2s ease-in-out infinite alternate;
      animation-delay: 0.5s;
    }

    .intro-text h1 .signature {
      font-family: 'Great Vibes', cursive;
      font-size: 3.6rem;
      color: var(--primary);
      text-shadow: 0 0 10px var(--primary), 0 0 20px var(--primary);
    }

    .intro-text p {
      font-size: 1.2rem;
      color: var(--text);
      line-height: 1.7;
      margin-top: 1.2rem;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 1s ease forwards, textGlow 3s ease-in-out infinite alternate;
      animation-delay: 1.5s;
    }

    .intro-video video {
      width: 100%;
      max-width: 600px;
      max-height: 600px;
      border-radius: 20px;
      border: 3px solid var(--glow-color);
      box-shadow: 0 0 30px var(--glow-color), 0 0 60px rgba(0, 191, 255, 0.6);
      opacity: 0;
      transform: scale(0.95);
      animation: fadeInScale 1.2s ease forwards, videoGlow 2.5s ease-in-out infinite alternate;
      animation-delay: 2.5s;
    }

    .intro-video video:hover {
      box-shadow: 0 0 60px var(--glow-color), 0 0 120px rgba(0, 191, 255, 1);
      transform: scale(1.03);
    }

    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInScale {
      0% { opacity: 0; transform: scale(0.95); }
      100% { opacity: 1; transform: scale(1); }
    }

    @keyframes textGlow {
      0% { text-shadow: 0 0 5px var(--glow-color), 0 0 10px var(--glow-color); }
      100% { text-shadow: 0 0 15px var(--glow-color), 0 0 35px var(--glow-color); }
    }

    @keyframes videoGlow {
      0% { box-shadow: 0 0 25px var(--glow-color), 0 0 60px rgba(0, 191, 255, 0.5); }
      100% { box-shadow: 0 0 60px var(--glow-color), 0 0 100px rgba(0, 191, 255, 0.8); }
    }

    @media (max-width: 992px) {
      .intro-text {
        text-align: center;
      }
      .intro-text h1 { font-size: 2.6rem; }
      .intro-text h1 .signature { font-size: 3rem; }
      .intro-text p { font-size: 1.1rem; }
      .intro-video video {
        max-width: 420px;
        margin-top: 30px;
      }
    }

    @media (max-width: 576px) {
      .intro-text h1 { font-size: 2rem; }
      .intro-text h1 .signature { font-size: 2.4rem; }
      .intro-text p { font-size: 1rem; }
    }

    /* 🔹 PROJECTS SECTION */
    .project-section {
      padding: 80px 0;
    }

    .project-section h2 {
      text-align: center;
      color: white;
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      margin-bottom: 60px;
      text-shadow: 0 0 15px var(--glow-color), 0 0 30px rgba(0, 191, 255, 0.7);
    }

    .project-card {
      background-color: #111;
      border: none;
      border-radius: 20px;
      padding: 20px;
      transition: all 0.4s ease;
      box-shadow: 0 0 25px rgba(0, 191, 255, 0.15);
    }

    .project-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 0 30px var(--glow-color), 0 0 60px rgba(0, 191, 255, 0.6);
    }

    .project-card img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0, 191, 255, 0.3);
      transition: transform 0.5s ease, box-shadow 0.5s ease;
    }

    .project-card img:hover {
      transform: scale(1.05);
      box-shadow: 0 0 25px var(--glow-color), 0 0 45px rgba(0, 191, 255, 0.8);
    }

    .project-card h5 {
      color: var(--primary);
      margin-top: 15px;
      font-weight: 600;
    }

    .project-card p {
      color: #ddd;
      font-size: 0.95rem;
      margin-top: 10px;
    }

    .project-btn {
      border-radius: 50px;
      margin-top: 15px;
      transition: all 0.3s ease;
    }

    .project-btn:hover {
      background-color: var(--glow-color);
      color: white;
      border-color: var(--glow-color);
      box-shadow: 0 0 15px var(--glow-color), 0 0 35px rgba(0, 191, 255, 0.7);
    }

    /* Reveal animation */
    .hidden {
      opacity: 0;
      transform: translateY(40px);
      transition: all 0.8s ease-out;
    }
    .visible {
      opacity: 1;
      transform: translateY(0);
    }








/* 🔹 Team Section */
#team h2 {
  color: white;
  font-family: 'Poppins', sans-serif;
  font-weight: 700;
  text-shadow: 0 0 15px var(--glow-color), 0 0 30px rgba(0, 191, 255, 0.7);
}

.team-card {
  background-color: #111;
  border-radius: 20px;
  transition: all 0.4s ease;
  box-shadow: 0 0 20px rgba(0, 191, 255, 0.15);
}

.team-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 0 35px var(--glow-color), 0 0 70px rgba(0, 191, 255, 0.6);
}

.team-img {
  width: 150px;
  height: 150px;
  object-fit: cover;
  box-shadow: 0 0 20px rgba(0, 191, 255, 0.5);
  transition: all 0.4s ease;
}

.team-img:hover {
  transform: scale(1.05);
  box-shadow: 0 0 35px var(--glow-color), 0 0 70px rgba(0, 191, 255, 0.8);
}





  </style>
</head>
<body>

  <!-- 🔹 Intro Section -->
  <div class="container-fluid intro-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-12 intro-text">
          <h1>
            I am <span class="signature">Talha Zeeshan</span>, a Full Stack Web Developer
          </h1>
          <p>
            Web Developer (Full Stack) — skilled in both frontend and backend development, with hands-on experience building and maintaining dynamic web applications. Proficient in HTML, CSS, JavaScript, PHP, Laravel, and MySQL, with a strong understanding of responsive design and clean coding practices.
          </p>
        </div>
        <div class="col-lg-6 col-md-12 text-center intro-video">
          <video src="img/videoplayback1.mp4" autoplay muted loop playsinline></video>
        </div>
      </div>
    </div>
  </div>

  <!-- 🔹 Projects Section -->
  <div class="container project-section">
    <h2>My Featured Projects</h2>
    <div class="row g-4 justify-content-center">

      <!-- Project 1 -->
      <div class="col-lg-4 col-md-6 col-sm-12 project hidden">
        <div class="project-card text-center">
          <img src="img/network-4118694_1920.jpg" alt="Restaurant Management System">
          <h5>Restaurant Management System</h5>
          <p>A complete system to manage restaurant menus, orders, and billing — built using Laravel & MySQL.</p>
          <a href="#" class="btn btn-outline-primary project-btn">Visit Project</a>
        </div>
      </div>

      <!-- Project 2 -->
      <div class="col-lg-4 col-md-6 col-sm-12 project hidden">
        <div class="project-card text-center">
          <img src="img/blockchain-7856212_1920.jpg" alt="School Admin System">
          <h5>School Admin System</h5>
          <p>A school management portal for handling students, teachers, attendance, and performance efficiently.</p>
          <a href="#" class="btn btn-outline-primary project-btn">Visit Project</a>
        </div>
      </div>

      <!-- Project 3 -->
      <div class="col-lg-4 col-md-6 col-sm-12 project hidden">
        <div class="project-card text-center">
          <img src="img/earth-3537401_1920.jpg" alt="Portfolio Website">
          <h5>Portfolio Website</h5>
          <p>A responsive and elegant personal portfolio showcasing skills, projects, and achievements.</p>
          <a href="#" class="btn btn-outline-primary project-btn">Visit Project</a>
        </div>
      </div>




       <!-- Project 1 -->
       <div class="col-lg-4 col-md-6 col-sm-12 project hidden">
        <div class="project-card text-center">
          <img src="img/world-6694125_1920.jpg" alt="Restaurant Management System">
          <h5>Restaurant Management System</h5>
          <p>A complete system to manage restaurant menus, orders, and billing — built using Laravel & MySQL.</p>
          <a href="#" class="btn btn-outline-primary project-btn">Visit Project</a>
        </div>
      </div>

      <!-- Project 2 -->
      <div class="col-lg-4 col-md-6 col-sm-12 project hidden">
        <div class="project-card text-center">
          <img src="img/web-1668927_1920.jpg" alt="School Admin System">
          <h5>School Admin System</h5>
          <p>A school management portal for handling students, teachers, attendance, and performance efficiently.</p>
          <a href="#" class="btn btn-outline-primary project-btn">Visit Project</a>
        </div>
      </div>

      <!-- Project 3 -->
      <div class="col-lg-4 col-md-6 col-sm-12 project hidden">
        <div class="project-card text-center">
          <img src="img/search-engine-5512814_1920.jpg" alt="Portfolio Website">
          <h5>Portfolio Website</h5>
          <p>A responsive and elegant personal portfolio showcasing skills, projects, and achievements.</p>
          <a href="#" class="btn btn-outline-primary project-btn">Visit Project</a>
        </div>
      </div>
    </div>
  </div>






<!-- 🔹 Our Team Section -->
<div class="container py-5" id="team">
  <h2 class="text-center mb-5">Our Team</h2>
  <div class="row justify-content-center g-4">

    <!-- Team Member 1 -->
    <div class="col-lg-4 col-md-6 text-center">
      <div class="team-card p-4">
        <img src="img/ai-generated-8684869_1920.jpg" alt="Team Member" class="rounded-circle border border-3 border-info mb-3 team-img">
        <h5 class="text-primary fw-bold">Talha Zeeshan</h5>
        <p class="text-light mb-1">Full Stack Developer</p>
        <p class="text">Expert in Laravel, PHP, MySQL, and modern frontend frameworks.</p>
      </div>
    </div>

    <!-- Team Member 2 -->
    <div class="col-lg-4 col-md-6 text-center">
      <div class="team-card p-4">
        <img src="img/developer-8764524_1920.jpg" alt="Team Member" class="rounded-circle border border-3 border-info mb-3 team-img">
        <h5 class="text-primary fw-bold">Ahmed Khan</h5>
        <p class="text-light mb-1">Frontend Developer</p>
        <p class="text">Specialized in responsive UI, animations, and modern web design.</p>
      </div>
    </div>

    <!-- Team Member 3 -->
    <div class="col-lg-4 col-md-6 text-center">
      <div class="team-card p-4">
        <img src="img/ai-generated-9241538_1920.jpg" alt="Team Member" class="rounded-circle border border-3 border-info mb-3 team-img">
        <h5 class="text-primary fw-bold">Arham Ali</h5>
        <p class="text-light mb-1">Backend Developer</p>
        <p class="text">Skilled in database design, REST APIs, and secure authentication.</p>
      </div>
    </div>
  </div>
</div>








  <!-- 🔹 Scroll Reveal Script -->
  <script>
    (function() {
      const items = document.querySelectorAll('.project.hidden');
      function revealOnScroll() {
        const winH = window.innerHeight;
        items.forEach((el, i) => {
          const rect = el.getBoundingClientRect();
          if (rect.top < winH * 0.9) {
            setTimeout(() => {
              el.classList.add('visible');
              el.classList.remove('hidden');
            }, i * 200);
          }
        });
      }
      window.addEventListener('scroll', revealOnScroll, { passive: true });
      window.addEventListener('load', revealOnScroll);
    })();
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
