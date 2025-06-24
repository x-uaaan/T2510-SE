<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="/image/CampusPulseIcon.png">
    <title>Campus Pulse | About</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
      .learnmore-btn {
        width: auto;
        display: flex;
        align-items: center;
        gap: 5px;
        background: #2d2e35;
        color: #fff;
        border: 1px solid #333;
        border-radius: 10px;
        padding: 10px 15px 10px 20px;
        font-weight: 600;
        transition: background 0.2s, border 0.2s, box-shadow 0.2s;
        cursor: pointer;
        justify-content: center;
        text-decoration: none;
      }
      .learnmore-btn:hover {
        background: #2d2e35;
        border: 1px solid #3b82f6;
        box-shadow: 0 0 0 2px #3b82f688;
        text-decoration: none;
      }
    </style>
</head>
<body class="min-h-screen bg-black text-white font-['Inter'] py-0 px-0">
    <!-- Hero Section -->
    <div class="w-full py-12 mb-12 flex flex-col items-center justify-center">
        <img src="/image/CampusPulseIcon.jpg" alt="Campus Pulse Logo" class="h-48 w-48 mb-4 rounded-full shadow-lg bg-gray-900" />
        <h1 class="text-5xl font-extrabold mb-2 text-white drop-shadow">About Campus Pulse</h1>
        <p class="text-lg text-gray-400 max-w-2xl text-center">Comprehensive alumni management platform designed to foster meaningful connections and collaboration within university communities.</p>
    </div>
    <div class="max-w-3xl mx-auto space-y-12 px-4 pb-16">
        <!-- About Us -->
        <section class="bg-gray-900 rounded-2xl shadow-lg p-8 border border-gray-800">
            <h2 class="text-3xl font-bold mb-4 text-white flex items-center">About Campus Pulse</h2>
            <p class="text-lg text-gray-300 mb-4">
                Campus Pulse is a comprehensive alumni management platform designed to foster meaningful connections and collaboration within university communities. Whether you're a current student, a recent graduate, or a seasoned alumnus, Campus Pulse brings everyone together under one digital roof.
            </p>
            <ul class="list-disc pl-6 text-gray-400 mb-4">
                <li class="mb-2"><b>Forums:</b> Engage in topic-specific discussions with peers, alumni, and faculty. Share insights, ask questions, and grow your professional and social networks.</li>
                <li class="mb-2"><b>Event Management:</b> Discover, organize, and participate in alumni events, networking sessions, workshops, and more. Stay informed about university happenings.</li>
                <li class="mb-2"><b>Vibrant Networking:</b> Reconnect with old classmates, build new connections, and explore mentorship opportunities. Leverage the strength of your university's community.</li>
            </ul>
            <p class="text-gray-400">
                Our mission is to bridge the gap between the past and present, creating a lasting sense of community and collaboration for the future.
            </p>
        </section>
        <!-- Issue Reporting -->
        <section class="bg-gray-900 rounded-2xl shadow-lg p-8 border border-gray-800">
            <h2 class="text-2xl font-bold mb-2 text-white flex items-center">Report an Issue</h2>
            <p class="text-gray-300 mb-2">We aim to provide a seamless and enjoyable experience for all our users. If you encounter bugs, technical glitches, or any usability concerns, please inform us so we can address the issue promptly.</p>
            <ul class="list-disc pl-6 text-gray-400 mb-2">
                <li><b>Email Us:</b> Send an email to <a href="mailto:support@campuspulse.com" class="underline">support@campuspulse.com</a> with a detailed description of the problem. Include screenshots or error messages if possible to help us better understand the issue.</li>
                <li><b>Provide Feedback:</b> Use the feedback feature on the platform (if available) to highlight the issue.</li>
                <li><b>Response Time:</b> Our support team strives to respond to all queries within 24-48 hours.</li>
            </ul>
            <p class="text-gray-400">Your feedback is invaluable to us in enhancing the Campus Pulse experience.</p>
        </section>
        <!-- Terms & Conditions -->
        <section class="bg-gray-900 rounded-2xl shadow-lg p-8 border border-gray-800">
            <h2 class="text-2xl font-bold mb-2 text-white flex items-center">Terms & Conditions</h2>
            <ul class="list-disc pl-6 text-gray-400 mb-2">
                <li><b>Respect for Community:</b> Always engage in a courteous and professional manner with fellow users. Offensive language, harassment, or inappropriate content is strictly prohibited.</li>
                <li><b>Compliance with University Guidelines:</b> Follow all rules and standards established by your university while using Campus Pulse.</li>
                <li><b>Accountability:</b> Misuse of the platform, such as spamming, sharing false information, or violating privacy, may result in immediate suspension or permanent termination of your account.</li>
                <li><b>Content Ownership:</b> Content you share must be original or appropriately credited. Campus Pulse reserves the right to moderate and remove any content that violates these terms.</li>
            </ul>
            <p class="text-gray-400">For the full Terms & Conditions, visit Campus Pulse Terms.</p>
        </section>
        <!-- Privacy Policy -->
        <section class="bg-gray-900 rounded-2xl shadow-lg p-8 border border-gray-800">
            <h2 class="text-2xl font-bold mb-2 text-white flex items-center">Privacy Policy</h2>
            <ul class="list-disc pl-6 text-gray-400 mb-2">
                <li><b>Data Storage:</b> Your personal information, including name, contact details, and activities, is securely encrypted and stored on our servers.</li>
                <li><b>No Unauthorized Sharing:</b> We will never sell, share, or distribute your information to third parties without your explicit consent.</li>
            </ul>
            <p class="text-gray-400 mb-2"><b>Purpose of Data Collection:</b></p>
            <ul class="list-disc pl-10 text-gray-400 mb-2">
                <li>To improve the platform and user experience.</li>
                <li>To personalize recommendations and event suggestions.</li>
                <li>To facilitate community interactions.</li>
            </ul>
            <p class="text-gray-400 mb-2"><b>User Rights:</b> You can request access, correction, or deletion of your data at any time by contacting our support team.</p>
            <p class="text-gray-400">For more details, reach out to <a href="mailto:support@campuspulse.com" class="underline">support@campuspulse.com</a> or visit the Privacy Policy section on our website.</p>
        </section>
        <!-- FAQ -->
        <section x-data="{ open: null }" class="bg-gray-900 rounded-2xl shadow-lg p-8 border border-gray-800">
            <h2 class="text-2xl font-bold mb-4 text-white flex items-center">Frequently Asked Questions</h2>
            <div class="space-y-4">
                <div>
                    <button @click="open === 1 ? open = null : open = 1" class="w-full text-left font-semibold focus:outline-none flex justify-between items-center py-2">
                        <span>How do I join Campus Pulse?</span>
                        <svg :class="{'rotate-180': open === 1}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open === 1" x-transition:enter="transition duration-700 ease-out" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak class="text-gray-400 pl-4 pb-2">
                        To become a part of our vibrant community:<br>
                        <ul class="list-decimal pl-6">
                            <li>Click the Sign Up button at the top right corner of our homepage.</li>
                            <li>Fill out the registration form with your details, including your university email and graduation year.</li>
                            <li>Verify your account via the confirmation email sent to your inbox.</li>
                            <li>Log in and start exploring!</li>
                        </ul>
                    </div>
                </div>
                <div>
                    <button @click="open === 2 ? open = null : open = 2" class="w-full text-left font-semibold focus:outline-none flex justify-between items-center py-2">
                        <span>Is my data safe?</span>
                        <svg :class="{'rotate-180': open === 2}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open === 2" x-transition:enter="transition duration-700 ease-out" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak class="text-gray-400 pl-4 pb-2">
                        Yes, your security is our top priority. We use advanced encryption methods and industry-standard practices to ensure your data is safe. Additionally, regular audits and security updates are performed to maintain robust protection against potential threats.
                    </div>
                </div>
                <div>
                    <button @click="open === 3 ? open = null : open = 3" class="w-full text-left font-semibold focus:outline-none flex justify-between items-center py-2">
                        <span>How can I participate in events?</span>
                        <svg :class="{'rotate-180': open === 3}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open === 3" x-transition:enter="transition duration-700 ease-out" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak class="text-gray-400 pl-4 pb-2">
                        Explore upcoming events by navigating to the Events section. Here, you'll find:
                        <ul class="list-disc pl-6">
                            <li>A calendar view of all events.</li>
                            <li>Filters to search by category, date, or interest.</li>
                            <li>Registration buttons to easily sign up for events that catch your eye.</li>
                        </ul>
                        Once registered, you'll receive reminders and updates about the event.
                    </div>
                </div>
                <div>
                    <button @click="open === 4 ? open = null : open = 4" class="w-full text-left font-semibold focus:outline-none flex justify-between items-center py-2">
                        <span>Who can I contact for help?</span>
                        <svg :class="{'rotate-180': open === 4}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open === 4" x-transition:enter="transition duration-700 ease-out" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak class="text-gray-400 pl-4 pb-2">
                        For assistance, reach out to our dedicated support team at <a href="mailto:support@campuspulse.com" class="underline">support@campuspulse.com</a>. Whether it's a technical issue or a question about features, we're here to help!
                    </div>
                </div>
            </div>
        </section>
        <!-- Call to Action -->
        <section class="flex flex-col items-center justify-center py-12">
          <div class="w-full max-w-xl bg-black border-gray-800 rounded-2xl shadow-lg flex flex-col items-center gap-2 py-12 px-6">
            <h2 class="text-2xl font-bold text-white mb-2">Ready to get started?</h2>
            <p class="text-gray-400 mb-6 text-center">Join the Campus Pulse community or learn more about our platform.</p>
            <div class="flex flex-col sm:flex-row gap-6 w-full justify-center">
              <a href="/auth/microsoft" class="learnmore-btn flex-1 text-center justify-center">Get Started</a>
              <a href="/about" class="learnmore-btn flex-1 text-center justify-center">Learn More</a>
            </div>
          </div>
        </section>
    </div>
</body>
</html>