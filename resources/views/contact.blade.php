<x-header title="Contact Us - Dot Poster" />

<x-layout>
    <div class="max-w-6xl mx-auto">
        <!-- Success/Error Messages -->
        @if (session('success'))
            <div
                class="mb-8 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div
                class="mb-8 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-gray-800 dark:text-gray-100 mb-4">Get in Touch</h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 leading-relaxed">We'd love to hear from you. Send us a
                message and we'll respond as soon as possible.</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg dark:shadow-emerald-900 p-8">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Send us a Message</h2>
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">First Name
                                *</label>
                            <input type="text" name="first_name" id="first_name" required
                                class="w-full px-4 py-3 border rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('first_name') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                                value="{{ old('first_name') }}" placeholder="John">
                            @error('first_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="last_name"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Last Name
                                *</label>
                            <input type="text" name="last_name" id="last_name" required
                                class="w-full px-4 py-3 border rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('last_name') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                                value="{{ old('last_name') }}" placeholder="Doe">
                            @error('last_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Email Address
                            *</label>
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-3 border rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('email') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                            value="{{ old('email') }}" placeholder="john@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subject"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Subject *</label>
                        <select name="subject" id="subject" required
                            class="w-full px-4 py-3 border rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('subject') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-700 @enderror">
                            <option value="">Choose a subject</option>
                            <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry
                            </option>
                            <option value="order" {{ old('subject') == 'order' ? 'selected' : '' }}>Order Support
                            </option>
                            <option value="artist" {{ old('subject') == 'artist' ? 'selected' : '' }}>Artist
                                Partnership</option>
                            <option value="technical" {{ old('subject') == 'technical' ? 'selected' : '' }}>Technical
                                Issue</option>
                            <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Feedback
                            </option>
                        </select>
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Message *</label>
                        <textarea name="message" id="message" rows="6" required
                            class="w-full px-4 py-3 border rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none @error('message') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-700 @enderror"
                            placeholder="Tell us how we can help you...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-700 dark:hover:bg-emerald-800 text-white font-semibold py-3 px-6 rounded-lg transition-colors shadow-lg dark:shadow-emerald-900 hover:shadow-xl">
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Contact Details -->
                <div class="bg-emerald-50 dark:bg-emerald-900 rounded-2xl p-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Contact Information</h2>
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="bg-emerald-100 p-3 rounded-full">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">Address</h3>
                                <p class="text-gray-600 dark:text-gray-300">123 Art Street<br>Creative District<br>New
                                    York, NY 10001</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-emerald-100 p-3 rounded-full">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">Phone</h3>
                                <p class="text-gray-600 dark:text-gray-300">+1 (555) 123-4567</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-emerald-100 p-3 rounded-full">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">Email</h3>
                                <p class="text-gray-600 dark:text-gray-300">hello@dotposter.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Business Hours</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Monday - Friday</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-100">9:00 AM - 6:00 PM EST</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Saturday</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-100">10:00 AM - 4:00 PM EST</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Sunday</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-100">Closed</span>
                        </div>
                    </div>
                    <div class="mt-6 p-4 bg-emerald-100 dark:bg-emerald-900 rounded-lg">
                        <p class="text-sm text-emerald-700 dark:text-emerald-300">
                            <strong>Response Time:</strong> We typically respond to all inquiries within 24 hours during
                            business days.
                        </p>
                    </div>
                </div>

                <!-- FAQ Link -->
                <div class="bg-blue-50 dark:bg-blue-900 rounded-2xl p-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Need Quick Answers?</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">Check out our frequently asked questions for
                        instant help with common inquiries.</p>
                    <a href="#"
                        class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold">
                        Visit FAQ Section
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
<x-footer />
