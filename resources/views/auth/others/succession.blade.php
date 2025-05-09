@extends('layouts.hr3-admin')

@section('title')
    Dashboard
@endsection
@section('content')
<div class="container mx-auto max-w-full w-full px-4">
    <!-- Certificate Generator Panel -->
    <div class="bg-white shadow-2xl rounded-2xl p-8 mb-8 w-full">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Travel and Tours Recognition Certificate Generator</h1>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Left Side: Input Fields -->
            <div class="space-y-4">
                <div>
                    <label class="block text-2xl font-medium text-gray-700 mb-2">Recipient Name</label>
                    <select id="recipientName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        <option value="">Select a recipient</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee['first_name'] }} {{ $employee['last_name'] }}">
                                {{ $employee['first_name'] }} {{ $employee['last_name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-2xl font-medium text-gray-700 mb-2">Achievement/Tour</label>
                    <select id="achievement" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        <option value="">Select an achievement or tour</option>
                        <option value="Leadership Award">Leadership Award</option>
                        <option value="Innovation Recognition">Innovation Recognition</option>
                        <option value="Service Excellence Award">Service Excellence Award</option>
                        <option value="Certificate of Employement">Certificte Of Employment</option>
                        <option value="International Mission">International Mission</option>
                        <option value="Special_Project">Special Project Completion</option>
                        <option value="Training Excellence">Training Excellence</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>

                <div>
                    <label class="block text-2xl font-medium text-gray-700 mb-2">Date of Recognition</label>
                    <input type="date" id="certDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-2xl font-medium text-gray-700 mb-2">Certificate Template</label>
                    <select id="templateSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" onchange="updateTemplatePreview()">
                        <option value="classic">Certification Classic</option>
                        <option value="nature">Employee Recognition</option>
                        {{-- <option value="global">Global Traveler</option> --}}
                    </select>
                </div>

                <div class="flex space-x-4">
                    <button onclick="generateCertificate()" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                        Generate Certificate
                    </button>
                </div>
            </div>

            <!-- Right Side: Preview -->
            <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-center">
                <div id="certificatePreview" class="w-full h-96 bg-white shadow-md rounded-lg flex items-center justify-center text-gray-400">
                    Certificate Preview
                </div>
            </div>
        </div>
    </div>

    <!-- Classic Travel Certificate -->
    <div id="generatedClassicCertificate" class="hidden relative bg-white shadow-2xl rounded-2xl overflow-hidden w-full mx-auto mt-8 border-8 border-yellow-400">

        <div class="absolute inset-0 p-2" style="background: repeating-linear-gradient(45deg, #f0c522, #f0c522 10px, #ffde59 10px, #ffde59 20px);"></div>

        <!-- Certificate container -->
        <div class="relative m-1 rounded-lg overflow-hidden w-full" style="background-image: linear-gradient(135deg, rgba(255,236,170,0.2) 0%, rgba(255,255,255,0.8) 50%, rgba(173,216,230,0.2) 100%);">

            <!-- Decorative corners -->
            <div class="absolute top-0 left-0 w-16 h-16 border-t-8 border-l-8 border-blue-600 rounded-tl-lg"></div>
            <div class="absolute top-0 right-0 w-16 h-16 border-t-8 border-r-8 border-blue-600 rounded-tr-lg"></div>
            <div class="absolute bottom-0 left-0 w-16 h-16 border-b-8 border-l-8 border-blue-600 rounded-bl-lg"></div>
            <div class="absolute bottom-0 right-0 w-16 h-16 border-b-8 border-r-8 border-blue-600 rounded-br-lg"></div>

            <!-- Certificate Header -->
            <div class="relative p-6" style="background-image: linear-gradient(90deg, #f0c522 0%, #fef9e7 20%, #ffffff 50%, #e8f4fd 80%, #1a5fb4 100%);">
                <div class="flex justify-between items-center">
                    <div class="w-1/4">
                        <div class="bg-gradient-to-br from-green-500 to-green-700 text-white rounded-full h-20 w-20 flex items-center justify-center font-bold text-2xl shadow-lg border-4 border-white">
                            JVD
                        </div>
                    </div>
                    <div class="w-2/4 text-center">
                        <h1 class="text-green-600 font-bold text-2xl tracking-wide">JVD EVENT AND TRAVEL MANAGEMENT COMPANY</h1>
                        <div class="h-px bg-gradient-to-r from-transparent via-blue-500 to-transparent my-2"></div>
                        <p class="text-xl text-gray-600 italic">Is hereby awarded this</p>
                    </div>
                    <div class="w-1/4 flex justify-end">
                        <div class="h-20 w-20 bg-white rounded-full flex items-center justify-center border-4 border-red-500 shadow-lg">
                            <div class="h-16 w-16 rounded-full flex items-center justify-center overflow-hidden">
                                <div class="w-full h-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center">
                                    <img src="{{asset('img/jvdlogo.png')}}" alt="Logo" class="object-contain" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certificate Body -->
            <div class="p-8 text-center bg-white bg-opacity-80 relative">
                <!-- Decorative watermark -->
                <div class="absolute inset-0 flex items-center justify-center opacity-5 pointer-events-none">
                    <div class="w-96 h-96 rounded-full border-8 border-blue-500"></div>
                    <div class="absolute w-80 h-80 rounded-full border-8 border-yellow-500"></div>
                </div>

                <h2 class="text-2xl font-semibold mb-3 text-gray-700">Certificate of Participation</h2>
                <h1 id="outputClassicRecipientName" class="text-5xl font-bold text-green-600 italic mb-6" style="font-family: 'Cormorant Garamond', serif;">[Recipient Name]</h1>
                <p class="mb-6 text-gray-700">has actively participated in the</p>
                <div class="py-2 px-4 bg-blue-600 bg-opacity-10 rounded-lg mb-6">

                    <h3 id="outputClassicAchievement" class="text-2xl font-bold text-blue-600">[Achievement/Tour]</h3>
                </div>
                <p class="mb-4 text-gray-700 max-w-2xl mx-auto">For his/her active participation during the Three-day Live-in Seminar on the following topic: Eco-sustainability, Renewable Energy Solution for Education, Networking and Promoting Energy Efficiency, Conservation Software Development, Building Green Digital Future with the theme:</p>
                <p class="text-xl italic font-medium mb-6 text-green-700 px-8 py-2 border-t border-b border-green-200">"Technology Friendly Conservation Development Building Green Digital Future"</p>
                <p class="mb-4 text-gray-700">held on <span id="outputClassicDate">[Date]</span> at Baguio Teacher's Camp, Baguio City.</p>
            </div>

            <!-- Certificate Footer -->
            <div class="p-6" style="background-image: linear-gradient(90deg, #f0c522 0%, #fef9e7 20%, #ffffff 50%, #e8f4fd 80%, #1a5fb4 100%);">
                <div class="flex justify-between items-end">
                    <div class="text-center w-40">
                        <div class="h-0.5 w-40 bg-gray-800 mb-2 mx-auto"></div>
                        <p class="font-bold text-gray-800 ">JHUNE ERNEST II R. OGOY</p>
                        <p class="text-xs text-gray-600">General Manager JVD ETMC</p>
                    </div>
                    <div class="text-center w-40">
                        <div class="h-0.5 w-40 bg-gray-800 mb-2 mx-auto"></div>
                        <p class="font-bold text-gray-800">DR. CHARLIE I. CARINO</p>
                        <p class="text-xs text-gray-600">Vice President for Academic Affairs</p>
                    </div>
                </div>
                <div class="mt-6 flex justify-between items-center">
                    <div class="bg-white p-2 rounded-lg shadow-md h-24 w-24">
                        <img src="{{ asset('img/qr.png') }}" alt="QR Code" class="max-w-full max-h-full">
                    </div>
                    <div class="flex gap-4">
                        <div class="bg-blue-600 rounded-full p-1 shadow-md">
                            <div class="rounded-full bg-white flex items-center justify-center">
                                <img src="{{asset('img/jvdlogo.png')}}" alt="Logo 1" class="w-20 h-20 object-contain" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nature Explorer Certificate -->
    <div id="generatedNatureCertificate" class="hidden relative bg-white shadow-2xl rounded-2xl overflow-hidden w-full mx-auto mt-8 border-8 border-green-100">
        <!-- Decorative border pattern -->
        <div class="absolute inset-0 p-2" style="background: repeating-linear-gradient(45deg, rgba(90, 79, 240, 0.1), rgba(94, 84, 233, 0.1) 10px, rgba(89, 73, 236, 0.1) 10px, rgba(46, 204, 113, 0.1) 20px);"></div>

        <!-- Certificate container -->
        <div class="relative m-1 rounded-lg overflow-hidden w-full bg-gradient-to-b from-green-50 to-white">
            <!-- Certificate Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-8 px-8 text-center">
                <div class="flex justify-between items-center mb-4">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg border-4 border-yellow-400">
                        <img src="{{asset('img/jvdlogo.png')}}" alt="JVD Logo" class="w-20 h-20 object-contain p-2">
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-white" style="font-family: 'Playfair Display', serif;">JVD TRAVEL AND TOURS</h1>
                        <p class="text-yellow-300 italic text-xl">Employee Excellence Recognition</p>
                        <div class="h-px bg-gradient-to-r from-transparent via-yellow-400 to-transparent my-3"></div>
                        <p class="text-white font-bold text-2xl">BESTLINK COLLEGE OF THE PHILIPPINES</p>
                    </div>
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg border-4 border-yellow-400">
                        <div class="w-20 h-20 rounded-full bg-blue-700 flex items-center justify-center text-white text-4xl">🏆</div>
                    </div>
                </div>
            </div>

            <!-- Certificate Body -->
            <div class="p-8 text-center relative">
                <!-- Decorative elements -->
                <div class="absolute top-4 left-4 w-16 h-16 border-2 border-green-400 rounded-full opacity-20"></div>
                <div class="absolute bottom-4 right-4 w-16 h-16 border-2 border-green-400 rounded-full opacity-20"></div>

                <!-- Watermark -->
                <div class="absolute inset-0 opacity-10 flex items-center justify-center">
                    <div class="text-green-200 text-9xl font-bold" style="transform: rotate(-30deg);">EXCELLENCE</div>
                </div>

                <div class="relative z-10">
                    <h2 class="text-2xl text-gray-600 mb-2">THIS CERTIFICATE IS PROUDLY AWARDED TO</h2>
                    <h1 id="outputNatureRecipientName" class="text-5xl font-bold text-green-800 mb-8 underline decoration-yellow-500" style="font-family: 'Playfair Display', serif;">[Employee Full Name]</h1>

                    <div class="mb-8">
                        <p class="text-xl text-gray-700 mb-4">In recognition of outstanding performance as</p>
                        <div class="inline-block px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-full shadow-lg">
                            <h3 id="outputNatureAchievement" class="text-3xl font-bold text-white">TOP PERFORMING EMPLOYEE</h3>
                        </div>
                    </div>

                    <div class="max-w-2xl mx-auto mb-8 bg-white bg-opacity-80 p-6 rounded-lg">
                        <p class="text-lg text-gray-700">
                            For demonstrating exceptional leadership in team projects, consistently providing innovative solutions to challenges,
                            and active participation in all company training programs and seminars.
                        </p>
                        <p class="text-lg text-gray-700 mt-4">
                            Your dedication and commitment to excellence have significantly contributed to our company's success.
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-6 mb-8">
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <div class="text-green-600 text-4xl mb-2">👑</div>
                            <h4 class="font-bold text-green-800 text-xl">Leadership</h4>
                            <p class="text-sm text-gray-600">Guiding teams to success</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                            <div class="text-yellow-600 text-4xl mb-2">💡</div>
                            <h4 class="font-bold text-yellow-800 text-xl">Innovation</h4>
                            <p class="text-sm text-gray-600">Creative problem solving</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <div class="text-blue-600 text-4xl mb-2">📊</div>
                            <h4 class="font-bold text-blue-800 text-xl">Performance</h4>
                            <p class="text-sm text-gray-600">Exceeding targets</p>
                        </div>
                    </div>

                    <div class="mb-8">
                        <p class="text-gray-600 text-xl">Awarded on</p>
                        <p id="outputNatureDate" class="text-2xl font-bold text-green-800">[Date]</p>
                    </div>
                </div>
            </div>

            <!-- Certificate Footer -->
            <div class="bg-green-50 p-8 border-t border-green-200">
                <div class="flex justify-between mb-8">
                    <div class="text-center w-1/3">
                        <div class="h-1 w-32 bg-green-600 mx-auto mb-3"></div>
                        <p class="font-bold text-gray-800 text-xl">JHUNE ERNEST II R. OGOY</p>
                        <p class="text-sm text-gray-600">General Manager</p>
                        <p class="text-sm text-gray-600">JVD ETMC</p>
                    </div>
                    <div class="text-center w-1/3">
                        <div class="h-1 w-32 bg-green-600 mx-auto mb-3"></div>
                        <p class="font-bold text-gray-800 text-xl">DR. CHARLIE I. CARINO</p>
                        <p class="text-sm text-gray-600">Vice President</p>
                        <p class="text-sm text-gray-600">Academic Affairs</p>
                    </div>
                </div>

                <div class="flex justify-center items-center">
                    <div class="bg-white p-3 rounded-lg shadow-md mr-6">
                        <div class="w-24 h-24 bg-gray-100 flex items-center justify-center text-sm text-gray-500 border border-gray-300">
                            <img src="{{ asset('img/qr.png') }}" alt="QR Code" class="max-w-full max-h-full">
                        </div>

                    </div>
                    <div class="text-left">
                        <p class="text-sm text-gray-600"><span class="font-bold">Certificate ID:</span> JVD-EMP-<span id="certificateId">XXXXXX</span></p>
                        <p class="text-xs text-gray-500 mt-2">This certificate is digitally signed and verifiable</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Global Traveler Certificate -->
    <div id="generatedGlobalCertificate" class="hidden relative bg-white shadow-2xl rounded-2xl overflow-hidden w-full mx-auto mt-8 border-8 border-indigo-100">
        <div class="absolute inset-0 opacity-20">
            <img src="{{asset('img/jvdlogo.png')}}" alt="Nature Background" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" class="w-full h-full">
                <path d="M500 200 Q700 400, 500 600 Q300 400, 500 200 Z" fill="#4338ca" opacity="0.1"/>
                <path d="M200 500 Q400 700, 600 500 Q400 300, 200 500 Z" fill="#4338ca" opacity="0.1"/>
            </svg>
        </div>

        <div class="absolute inset-0 pointer-events-none" style="border: 20px solid rgba(67, 56, 202, 0.2);"></div>

        <div class="relative z-10 p-16 text-center">
            <h1 class="text-6xl font-bold text-indigo-900 mb-6 tracking-wide" style="font-family: 'Playfair Display', serif;">
                GLOBAL TRAVELER CERTIFICATE
            </h1>

            <div class="w-full h-1 bg-indigo-800 mb-8 opacity-50" style="background: linear-gradient(90deg, transparent, #4338ca, transparent);"></div>

            <div class="my-10">
                <p class="text-2xl mb-4 text-indigo-900">This certificate celebrates the remarkable journey of</p>
                <h2 id="outputGlobalRecipientName" class="text-5xl font-bold text-indigo-900 mb-6" style="font-family: 'Merriweather', serif;"></h2>

                <p class="text-2xl mb-4 text-indigo-900">In recognition of exceptional</p>
                <h3 id="outputGlobalAchievement" class="text-4xl italic text-indigo-800 mb-6"></h3>

                <p class="text-2xl mb-4 text-indigo-900">Accomplished on</p>
                <p id="outputGlobalDate" class="text-3xl text-indigo-900 mb-10"></p>
            </div>

            <div class="flex justify-between items-center mt-16 px-20">
                <div class="text-center">
                    <div class="h-0.5 w-64 bg-green-900 mb-4 mx-auto"></div>
                    <p class="font-semibold text-green-900 text-xl">Travel Director</p>
                    <p class="text-green-700">JVD Event and Travel Management</p>
                </div>

                <div class="text-center">
                    <div class="h-0.5 w-64 bg-green-900 mb-4 mx-auto"></div>
                    <p class="font-semibold text-green-900 text-xl">Chief Executive Officer</p>
                    <p class="text-green-700">JVD Event and Travel Management</p>
                </div>
            </div>

            <div class="mt-16 text-2xl text-indigo-800 opacity-70">
                <p>© 2024 JVD Global Adventures, Co.</p>
                <p>"Connecting Cultures, Bridging Worlds"</p>
            </div>
        </div>
    </div>

    <!-- Buttons for Email and PDF Download -->
    <div class="flex justify-center mt-6 space-x-4">
        <button onclick="openModal()" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700">
            Send Certificate
        </button>
        <button onclick="downloadPDF()" class="px-6 py-3 bg-green-600 text-white font-bold rounded-lg shadow-md hover:bg-green-700">
            Download as PDF
        </button>
    </div>
<!-- Certificate Email Modal -->
<div id="emailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
    <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Send Certificate</h3>
            <div class="mt-2 px-7 py-3">
                <div class="mb-4">
                    <label for="recipientEmail" class="block text-gray-700 text-2xl font-bold mb-2">Recipient Email:</label>
                    <input type="email" id="recipientEmail" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="certificateFile" class="block text-gray-700 text-2xl font-bold mb-2">Certificate PDF:</label>
                    <input type="file" id="certificateFile" accept=".pdf" name="certificateFile" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div id="emailStatus" class="my-2"></div>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeModal" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button id="sendEmailBtn" onclick="sendEmail()" class="px-4 py-2 bg-purple-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    Send Email
                </button>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    function updateTemplatePreview() {
        const templateSelect = document.getElementById('templateSelect');
        const preview = document.getElementById('certificatePreview');

        switch(templateSelect.value) {
            case 'classic':
                preview.innerHTML = 'Classic Travel Certificate Preview';
                preview.style.backgroundColor = '#f8f4e8';
                break;
            case 'nature':
                preview.innerHTML = 'Nature Explorer Certificate Preview';
                preview.style.backgroundColor = '#e6f3e6';
                break;
            case 'global':
                preview.innerHTML = 'Global Traveler Certificate Preview';
                preview.style.backgroundColor = '#e6e6f9';
                break;
        }
    }

    function generateCertificate() {
        const recipientName = document.getElementById('recipientName').value;
        const achievement = document.getElementById('achievement').value;
        const certDate = document.getElementById('certDate').value;
        const templateSelect = document.getElementById('templateSelect').value;

        if (!recipientName || !achievement || !certDate) {
            alert('Please fill in all fields');
            return;
        }

        // Format date
        const formattedDate = new Date(certDate).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        // Hide all certificates
        document.getElementById('generatedClassicCertificate').classList.add('hidden');
        document.getElementById('generatedNatureCertificate').classList.add('hidden');
        document.getElementById('generatedGlobalCertificate').classList.add('hidden');

        // Update and show selected certificate
        switch(templateSelect) {
            case 'classic':
                document.getElementById('outputClassicRecipientName').textContent = recipientName;
                document.getElementById('outputClassicAchievement').textContent = achievement;
                document.getElementById('outputClassicDate').textContent = formattedDate;
                document.getElementById('generatedClassicCertificate').classList.remove('hidden');
                break;
            case 'nature':
                document.getElementById('outputNatureRecipientName').textContent = recipientName;
                document.getElementById('outputNatureAchievement').textContent = achievement;
                document.getElementById('outputNatureDate').textContent = formattedDate;
                document.getElementById('generatedNatureCertificate').classList.remove('hidden');
                break;
            case 'global':
                document.getElementById('outputGlobalRecipientName').textContent = recipientName;
                document.getElementById('outputGlobalAchievement').textContent = achievement;
                document.getElementById('outputGlobalDate').textContent = formattedDate;
                document.getElementById('generatedGlobalCertificate').classList.remove('hidden');
                break;
        }

        // Scroll to certificate
        document.querySelector('.hidden[id^="generated"]').scrollIntoView({ behavior: 'smooth' });
    }

    // Initialize template preview on page load
    updateTemplatePreview();
</script>

<script>
   function downloadPDF() {
    const templateSelect = document.getElementById('templateSelect').value;
    let certificateElement;

    switch(templateSelect) {
        case 'classic':
            certificateElement = document.getElementById('generatedClassicCertificate');
            break;
        case 'nature':
            certificateElement = document.getElementById('generatedNatureCertificate');
            break;
        case 'global':
            certificateElement = document.getElementById('generatedGlobalCertificate');
            break;
        default:
            alert('Please generate a certificate first');
            return;
    }

    if (typeof jspdf === 'undefined') {
        alert('PDF library not loaded. Please refresh the page.');
        return;
    }

    const { jsPDF } = window.jspdf;

    // Create PDF in landscape orientation with A4 dimensions
    const doc = new jsPDF({
        orientation: 'landscape',
        unit: 'mm',  // Use millimeters for more precise sizing
        format: 'a4'
    });

    const recipientName = certificateElement.querySelector('[id^="outputClassic"], [id^="outputNature"], [id^="outputGlobal"]').textContent.trim();
    const templateName = templateSelect.charAt(0).toUpperCase() + templateSelect.slice(1) + '_Traveler';

    html2canvas(certificateElement, {
        scale: 4,  // Increased scale for higher quality
        useCORS: true,
        allowTaint: true,
        logging: false,
        backgroundColor: null,  // Preserve transparency
        width: certificateElement.offsetWidth,
        height: certificateElement.offsetHeight
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');

        // Get A4 dimensions in mm
        const pageWidth = 297;  // A4 landscape width
        const pageHeight = 210;

        // Calculate image dimensions to maintain aspect ratio
        const aspectRatio = canvas.width / canvas.height;
        let imgWidth, imgHeight;

        // Fit image to page width with some margin
        imgWidth = pageWidth - 20;  // 10mm margin on each side
        imgHeight = imgWidth / aspectRatio;

        // If image is too tall, adjust
        if (imgHeight > pageHeight - 20) {
            imgHeight = pageHeight - 20;
            imgWidth = imgHeight * aspectRatio;
        }

        // Calculate position to center the image
        const xPos = (pageWidth - imgWidth) / 2;
        const yPos = (pageHeight - imgHeight) / 2;

        // Add image to PDF
        doc.addImage(
            imgData,
            'PNG',
            xPos,
            yPos,
            imgWidth,
            imgHeight,
            '',
            'FAST'
        );
        doc.save(`${templateName}_Certificate_for_${recipientName.replace(/\s+/g, '_')}.pdf`);
    }).catch(error => {
        console.error('Error generating PDF:', error);
        alert('Failed to generate PDF. Please try again.');
    });
}
</script>

<script>
   // JavaScript for sending congratulatory email
function openModal() {
    document.getElementById("emailModal").classList.remove("hidden");
}

function closeModal() {
    document.getElementById("emailModal").classList.add("hidden");
}

function sendEmail() {

    const recipientEmail = document.getElementById("recipientEmail").value;
    const certificateFile = document.getElementById("certificateFile").files[0];
    const emailStatus = document.getElementById("emailStatus");

    console.log("Email:", recipientEmail);
    console.log("File:", certificateFile);
    // Reset status
    emailStatus.textContent = "";
    emailStatus.className = "";

    // Validate inputs
    if (!recipientEmail) {
        emailStatus.textContent = "Please enter a recipient email address.";
        emailStatus.className = "text-red-500";
        return;
    }

    if (!certificateFile) {
        emailStatus.textContent = "Please upload a certificate file.";
        emailStatus.className = "text-red-500";
        return;
    }

    // Show loading state
    emailStatus.textContent = "Sending email...";
    emailStatus.className = "text-blue-500";

    const formData = new FormData();
    formData.append("recipientEmail", recipientEmail);
    formData.append("certificateFile", certificateFile);

    // Make sure this matches your route exactly
    fetch('/send-congratulatory-email', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            emailStatus.textContent = "Email sent successfully!";
            emailStatus.className = "text-green-500";
            setTimeout(() => {
                closeModal();
                // Reset form
                document.getElementById("recipientEmail").value = "";
                document.getElementById("certificateFile").value = "";
            }, 2000);
        } else {
            emailStatus.textContent = "Error: " + (data.message || "Unknown error");
            emailStatus.className = "text-red-500";
        }
    })
    .catch(error => {
        console.error("Error:", error);
        emailStatus.textContent = "An error occurred while sending the email.";
        emailStatus.className = "text-red-500";
    });
}
</script>
@endsection
