<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Str;

class NigeriaEconomyPostSeeder extends Seeder
{
    public function run(): void
    {
        Post::create([
            'title' => 'Nigerian Economy: Challenges and Opportunities',
            'slug' => 'nigerian-economy-challenges-and-opportunities',
            'content' => '<div class="prose max-w-none">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Nigerian Economy: Challenges and Opportunities</h1>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <div class="lg:col-span-2">
                        <img src="https://images.unsplash.com/photo-1579546929518-7b1ad425473?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MXxzZVfo3ZXJ8fHx8&auto=format&fit=crop&w=1200&q=80" 
                             alt="Nigerian Economy - Lagos Skyline" 
                             class="w-full h-64 object-cover rounded-lg shadow-lg mb-6">
                        
                        <div class="space-y-6">
                            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Overview</h2>
                            <p class="text-gray-600 leading-relaxed mb-4">
                                Nigeria stands as Africa\'s largest economy and most populous nation. With a GDP of over $440 billion, the country possesses enormous potential across various sectors including oil and gas, telecommunications, agriculture, and a burgeoning tech ecosystem.
                            </p>
                            
                            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Key Economic Sectors</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h3 class="font-semibold text-blue-800 mb-2">💰 Oil & Gas</h3>
                                    <p class="text-gray-700">The backbone of Nigeria\'s economy, contributing significantly to GDP and export revenues.</p>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <h3 class="font-semibold text-green-800 mb-2">📱 Telecommunications</h3>
                                    <p class="text-gray-700">Rapidly growing sector with increasing mobile penetration and digital services.</p>
                                </div>
                                <div class="bg-yellow-50 p-4 rounded-lg">
                                    <h3 class="font-semibold text-yellow-800 mb-2">🌾 Agriculture</h3>
                                    <p class="text-gray-700">Employing over 35% of the population and contributing to food security.</p>
                                </div>
                                <div class="bg-purple-50 p-4 rounded-lg">
                                    <h3 class="font-semibold text-purple-800 mb-2">💻 Technology</h3>
                                    <p class="text-gray-700">Emerging tech hub with growing startup ecosystem and innovation centers.</p>
                                </div>
                            </div>
                            
                            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Challenges & Opportunities</h2>
                            <div class="bg-red-50 border-l-4 border-red-200 p-6 rounded-lg mb-6">
                                <h3 class="font-semibold text-red-800 mb-3">⚠️ Current Challenges</h3>
                                <ul class="list-disc list-inside space-y-2 text-gray-700">
                                    <li>Infrastructure deficits affecting business operations</li>
                                    <li>Currency fluctuations impacting investment decisions</li>
                                    <li>Regulatory complexities in certain sectors</li>
                                    <li>Youth unemployment requiring urgent attention</li>
                                </ul>
                            </div>
                            
                            <div class="bg-green-50 border-l-4 border-green-200 p-6 rounded-lg">
                                <h3 class="font-semibold text-green-800 mb-3">🚀 Growth Opportunities</h3>
                                <ul class="list-disc list-inside space-y-2 text-gray-700">
                                    <li>Expanding digital economy and fintech solutions</li>
                                    <li>Growing renewable energy sector investments</li>
                                    <li>Increasing foreign direct investment (FDI)</li>
                                    <li>Developing entertainment and creative industries</li>
                                    <li>Strengthening regional trade partnerships</li>
                                </ul>
                            </div>
                            
                            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Future Outlook</h2>
                            <p class="text-gray-600 leading-relaxed">
                                Despite facing significant challenges, Nigeria continues to attract foreign investment and maintains a resilient entrepreneurial spirit that drives innovation and economic growth. The country\'s young population, combined with increasing digital adoption, positions it well for future economic expansion and sustainable development.
                            </p>
                        </div>
                    </div>
                </div>
            </div>',
            'excerpt' => 'Exploring the dynamics of Nigeria\'s diverse economy and future prospects.',
            'user_id' => 1,
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
}
