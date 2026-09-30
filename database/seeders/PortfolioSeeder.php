<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\CapabilityHighlight;
use App\Models\Experience;
use App\Models\ExpertiseCategory;
use App\Models\ExpertisePrinciple;
use App\Models\ExpertiseStat;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        Profile::updateOrCreate([], [
            'name' => 'Ntohnwi Bih',
            'role_title' => 'Staff Software Engineer',
            'hero_title' => 'Building systems that scale and teams that ship.',
            'hero_highlight' => 'scale',
            'hero_description' => 'I design resilient architectures, lead cross-functional engineering teams, and turn ambiguous product goals into reliable software.',
            'photo_caption' => 'ENGINEERING WITH PURPOSE',
            'quote' => "Great engineering isn't just clean code — it's clarity of thought, empathy for users, and the courage to simplify what's complex.",
            'quote_author' => 'Ntohnwi Bih',
            'email' => 'mforbesintohnwi@gmail.com',
            'phone' => '+237 672 81 35 49',
            'location' => 'Yaoundé, Cameroon',
            'contact_intro' => "I'm open to staff engineering roles, advisory work, and conversations about high-impact product engineering.",
            'footer_text' => 'Built with intention.',
        ]);

        foreach (['GitHub', 'LinkedIn', 'Twitter'] as $i => $platform) {
            SocialLink::updateOrCreate(['platform' => $platform], ['url' => '#', 'order' => $i]);
        }

        $vertex = Experience::create([
            'role_title' => 'Staff Software Engineer', 'company' => 'Vertex Payments',
            'start_date' => '2021-01-01', 'is_current' => true, 'order' => 0,
        ]);
        $vertex->highlights()->createMany([
            ['description' => 'Led architecture for a real-time payment orchestration platform processing $2B+ annually.', 'order' => 0],
            ['description' => 'Grew the platform team from 4 to 14 engineers across 3 squads.', 'order' => 1],
            ['description' => 'Reduced critical-path latency by 60% through event-driven redesign and edge caching.', 'order' => 2],
            ['description' => 'Mentored 5 senior engineers to staff level; two now lead their own teams.', 'order' => 3],
        ]);

        $nova = Experience::create([
            'role_title' => 'Senior Software Engineer', 'company' => 'Nova Marketplace',
            'start_date' => '2017-01-01', 'end_date' => '2021-01-01', 'order' => 1,
        ]);
        $nova->highlights()->createMany([
            ['description' => 'Owned the seller experience team, rebuilding listing and inventory tools used by 40k+ merchants.', 'order' => 0],
            ['description' => 'Drove migration from monolith to micro-frontends, improving build times by 80%.', 'order' => 1],
            ['description' => 'Introduced design-system governance that cut UI regressions by half.', 'order' => 2],
            ['description' => 'Partnered with product and design to launch a new checkout flow that lifted conversion 12%.', 'order' => 3],
        ]);

        ExpertiseStat::insert([
            ['value' => '14', 'label' => 'Engineers mentored to senior+', 'order' => 0],
            ['value' => '60%', 'label' => 'Latency reduction', 'order' => 1],
            ['value' => '$2B+', 'label' => 'Annual payment volume', 'order' => 2],
            ['value' => '8', 'label' => 'Years in staff+ roles', 'order' => 3],
        ]);

        ExpertisePrinciple::insert([
            ['icon' => 'lightbulb', 'title' => 'Clarity over control', 'description' => 'I set clear goals and trust teams to own the how. My job is to remove ambiguity, not to micromanage.', 'order' => 0],
            ['icon' => 'rocket', 'title' => 'Ship small, learn fast', 'description' => 'Big bets are decomposed into small, reversible experiments. Momentum and feedback matter more than perfect plans.', 'order' => 1],
            ['icon' => 'people', 'title' => 'Invest in people', 'description' => 'The best systems are built by growing engineers. I prioritize mentorship, sponsorship, and psychological safety.', 'order' => 2],
        ]);

        $frontend = ExpertiseCategory::create(['icon' => 'layers', 'title' => 'Frontend Architecture', 'order' => 0]);
        $frontend->items()->createMany(collect(['React / Next.js', 'TypeScript', 'Design Systems', 'Performance', 'Accessibility'])->map(fn ($l, $i) => ['label' => $l, 'order' => $i])->all());

        $backend = ExpertiseCategory::create(['icon' => 'server', 'title' => 'Backend & Infrastructure', 'order' => 1]);
        $backend->items()->createMany(collect(['Node.js / Go', 'PostgreSQL', 'Redis', 'Kafka', 'Kubernetes'])->map(fn ($l, $i) => ['label' => $l, 'order' => $i])->all());

        Achievement::create([
            'title' => 'Real-time payment orchestration', 'subtitle' => 'Vertex Payments',
            'description' => 'Architected an event-driven payment platform that routes transactions across multiple processors with sub-second failover.',
            'icon' => 'bolt', 'metric_label' => '$2B+ processed', 'order' => 0,
        ])->tags()->createMany([['tag' => 'System Design'], ['tag' => 'Kafka'], ['tag' => 'Go']]);

        // Example of the Projects module in action — one frontend project, one backend project.
        $ui = Project::create([
            'title' => 'Seller Workbench Redesign',
            'slug' => 'seller-workbench-redesign',
            'type' => 'frontend',
            'short_description' => 'Micro-frontend rebuild of the seller tools suite.',
            'description' => 'Rebuilt the core seller experience from a monolithic app into a micro-frontend suite.',
            'tech_stack' => ['React', 'TypeScript', 'Vite'], 'is_featured' => true, 'status' => 'published', 'order' => 0,
        ]);
        $ui->links()->create(['label' => 'Live site', 'type' => 'live', 'url' => 'https://example.com', 'order' => 0]);

        $api = Project::create([
            'title' => 'Payment Orchestration Service',
            'slug' => 'payment-orchestration-service',
            'type' => 'backend',
            'short_description' => 'Event-driven payment routing engine.',
            'description' => 'Go service that routes transactions across processors with automatic failover.',
            'tech_stack' => ['Go', 'Kafka', 'PostgreSQL'], 'status' => 'published', 'order' => 1,
        ]);
        $api->links()->create(['label' => 'GitHub repo', 'type' => 'repo', 'url' => 'https://github.com/example/repo', 'order' => 0]);
    }
}