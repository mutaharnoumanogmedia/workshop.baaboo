<?php

namespace App\Http\Controllers;

use App\Models\Course;

class WorkshopController extends Controller
{
    public function index()
    {
        $myCourses = Course::active()->myCourses()->get();

        return view('workshops.index', compact('myCourses'));
    }

    public function show($id, $chapterId = null, $videoId = null)
    {
        $course = Course::findOrFail($id)->load('chapters.videos');
        $currentChapter = $chapterId ? $course->chapters->firstWhere('id', $chapterId) : $course->chapters->first();
        $currentVideo = $videoId && $currentChapter ? $currentChapter->contents->firstWhere('id', $videoId) : ($currentChapter ? $currentChapter->contents->first() : null);
        // $currentAudio = $videoId && $currentChapter ? $currentChapter->videos->firstWhere('video_type', 'audio') : ($currentChapter ? $currentChapter->videos->where('video_type', 'audio')->first() : null);

        return view('workshops.show', compact('course', 'currentChapter', 'currentVideo'));
    }

    public function module($id,  $moduleId)
    {
        $workshops = $this->demoWorkshops();
        $workshop = $workshops[$id] ?? null;
        abort_if(is_null($workshop), 404);

        $module = collect($workshop['modules'])->firstWhere('id', $moduleId);
        abort_if(is_null($module), 404);

        return view('workshops.show', [
            'workshop' => $workshop,
            'module' => $this->prepareModuleContext($workshop, $module),
            'modules' => $workshop['modules'],
        ]);
    }

    protected function prepareModuleContext(array $workshop, array $module): array
    {
        $details = $module['details'] ?? [];
        $currentLessonDefaults = [
            'title' => 'Placeholder Lesson',
            'summary' => 'Preview text for upcoming lesson.',
            'video' => 'https://www.youtube.com/embed/f77SKdyn-1Y',
            'duration' => '09:30',
            'resumePoint' => '00:00',
            'order' => 1,
        ];

        $currentLesson = array_merge($currentLessonDefaults, $details['currentLesson'] ?? []);

        $upNext = array_map(function ($item, $index) {
            $order = $item['order'] ?? ($index + 1);
            $thumbnail = $item['thumbnail'] ?? 'https://placehold.co/80x45/FF8C5A/white?text=' . $order;

            return array_merge([
                'order' => $order,
                'duration' => '05:00',
                'title' => 'Upcoming lesson',
                'thumbnail' => $thumbnail,
            ], $item);
        }, $details['upNext'] ?? [], array_keys($details['upNext'] ?? []));

        $lessonsListSource = $details['lessonsList'] ?? [];
        $lessonsList = array_map(function ($lesson, $index) {
            $order = $lesson['order'] ?? ($index + 1);

            return array_merge([
                'order' => $order,
                'title' => 'Lesson ' . $order,
                'summary' => 'Lesson summary placeholder.',
                'duration' => '06:00',
                'thumbnail' => 'https://placehold.co/240x135/FF8C5A/FFFFFF?text=' . str_pad($order, 2, '0', STR_PAD_LEFT),
                'state' => 'new',
                'active' => false,
            ], $lesson);
        }, $lessonsListSource, array_keys($lessonsListSource));

        return array_merge($module, [
            'currentLesson' => $currentLesson,
            'upNext' => $upNext,
            'lessonsList' => $lessonsList,
        ]);
    }

    protected function demoWorkshops(): array
    {
        return [
            'autogenic-training' => [
                'id' => 'autogenic-training',
                'title' => 'Autogenic Training',
                'summary' => 'Guided relaxation rituals for facilitators who want calmer cohorts.',
                'category' => 'Wellness',
                'updated' => '2 days ago',
                'duration' => '4 hours',
                'modulesCount' => 4,
                'modules' => [
                    [
                        'id' => 'foundations',
                        'name' => 'Chapter 1: Foundations',
                        'description' => 'Introduce the mindset, posture, and breathing cadence for autogenic practice.',
                        'lessons' => 5,
                        'duration' => '45 min',
                        'status' => 'in-progress',
                        'details' => [
                            'currentLesson' => [
                                'title' => 'Body Scan Warmup',
                                'summary' => 'Prime participants with a grounded body scan before deeper scripts.',
                                'video' => 'https://www.youtube.com/embed/f77SKdyn-1Y',
                                'duration' => '15:30',
                                'resumePoint' => '08:45',
                                'order' => 4,
                            ],
                            'upNext' => [
                                ['order' => 5, 'title' => 'Guided Visualisation', 'duration' => '12:45'],
                                ['order' => 6, 'title' => 'Facilitator Notes', 'duration' => '08:20'],
                                ['order' => 7, 'title' => 'Check-in Prompts', 'duration' => '10:15'],
                            ],
                            'lessonsList' => [
                                [
                                    'order' => 1,
                                    'title' => 'Course Orientation',
                                    'summary' => 'High-level walkthrough of the methodology and deliverables.',
                                    'duration' => '08:30',
                                    'thumbnail' => 'https://placehold.co/240x135/FF8C5A/FFFFFF?text=01',
                                    'state' => 'completed',
                                    'active' => false,
                                ],
                                [
                                    'order' => 2,
                                    'title' => 'Space Preparation',
                                    'summary' => 'Tools and environmental cues for on-site and remote groups.',
                                    'duration' => '12:15',
                                    'thumbnail' => 'https://placehold.co/240x135/FF8C5A/FFFFFF?text=02',
                                    'state' => 'completed',
                                    'active' => false,
                                ],
                                [
                                    'order' => 3,
                                    'title' => 'Posture Fundamentals',
                                    'summary' => 'Demonstrate chair and floor variations plus coaching notes.',
                                    'duration' => '10:45',
                                    'thumbnail' => 'https://placehold.co/240x135/FF8C5A/FFFFFF?text=03',
                                    'state' => 'completed',
                                    'active' => false,
                                ],
                                [
                                    'order' => 4,
                                    'title' => 'Body Scan Warmup',
                                    'summary' => 'Coach the slow sweep script with transition cues.',
                                    'duration' => '15:30',
                                    'thumbnail' => 'https://placehold.co/240x135/FF6B35/FFFFFF?text=04',
                                    'state' => 'in-progress',
                                    'active' => true,
                                ],
                                [
                                    'order' => 5,
                                    'title' => 'Guided Visualisation',
                                    'summary' => 'Layer imagery techniques to deepen relaxation.',
                                    'duration' => '12:45',
                                    'thumbnail' => 'https://placehold.co/240x135/FF8C5A/FFFFFF?text=05',
                                    'state' => 'locked',
                                    'active' => false,
                                ],
                            ],
                        ],
                    ],
                    [
                        'id' => 'coaching',
                        'name' => 'Chapter 2: Coaching Scripts',
                        'description' => 'Reusable scripts and prompts for 1:1 or group practice.',
                        'lessons' => 4,
                        'duration' => '35 min',
                        'status' => 'ready',
                        'details' => [
                            'currentLesson' => [
                                'title' => 'Anchor Statements',
                                'summary' => 'Craft statements that ground participants after a session.',
                                'video' => 'https://www.youtube.com/embed/oq6fZr2z3ok',
                                'duration' => '11:05',
                                'resumePoint' => '00:00',
                                'order' => 1,
                            ],
                            'upNext' => [
                                ['order' => 2, 'title' => 'Progressive Builds', 'duration' => '09:42'],
                                ['order' => 3, 'title' => 'Safety Considerations', 'duration' => '07:10'],
                            ],
                            'lessonsList' => [
                                [
                                    'order' => 1,
                                    'title' => 'Anchor Statements',
                                    'summary' => 'Keep participants centered when closing a session.',
                                    'duration' => '11:05',
                                    'thumbnail' => 'https://placehold.co/240x135/FFD7C2/FF6B35?text=01',
                                    'state' => 'new',
                                    'active' => true,
                                ],
                                [
                                    'order' => 2,
                                    'title' => 'Progressive Builds',
                                    'summary' => 'Increase complexity with layered prompts.',
                                    'duration' => '09:42',
                                    'thumbnail' => 'https://placehold.co/240x135/FFE5D6/FF6B35?text=02',
                                    'state' => 'locked',
                                    'active' => false,
                                ],
                                [
                                    'order' => 3,
                                    'title' => 'Safety Considerations',
                                    'summary' => 'Plan responses for emotional releases and regressions.',
                                    'duration' => '07:10',
                                    'thumbnail' => 'https://placehold.co/240x135/FFE5D6/FF6B35?text=03',
                                    'state' => 'locked',
                                    'active' => false,
                                ],
                                [
                                    'order' => 4,
                                    'title' => 'Group Debriefs',
                                    'summary' => 'Structured share-outs and journaling prompts.',
                                    'duration' => '09:18',
                                    'thumbnail' => 'https://placehold.co/240x135/FFE5D6/FF6B35?text=04',
                                    'state' => 'locked',
                                    'active' => false,
                                ],
                            ],
                        ],
                    ],
                    [
                        'id' => 'integration',
                        'name' => 'Chapter 3: Integration',
                        'description' => 'Follow-up plans and everyday micro-practices.',
                        'lessons' => 3,
                        'duration' => '25 min',
                        'status' => 'locked',
                    ],
                    [
                        'id' => 'retrospective',
                        'name' => 'Chapter 4: Retrospective',
                        'description' => 'Measure outcomes, collect testimonials, and reset goals.',
                        'lessons' => 2,
                        'duration' => '20 min',
                        'status' => 'locked',
                    ],
                ],
            ],
            'team-sync-design' => [
                'id' => 'team-sync-design',
                'title' => 'Team Sync Design Sprint',
                'summary' => 'A lightweight sprint playbook for async-first teams.',
                'category' => 'Productivity',
                'updated' => '5 days ago',
                'duration' => '3.5 hours',
                'modulesCount' => 3,
                'modules' => [
                    [
                        'id' => 'alignment',
                        'name' => 'Chapter 1: Alignment Pulse',
                        'description' => 'Clarify desired outcomes and sprint guardrails.',
                        'lessons' => 4,
                        'duration' => '40 min',
                        'status' => 'ready',
                    ],
                    [
                        'id' => 'workshops',
                        'name' => 'Chapter 2: Live Workshops',
                        'description' => 'Structure virtual collaboration windows.',
                        'lessons' => 3,
                        'duration' => '55 min',
                        'status' => 'locked',
                    ],
                    [
                        'id' => 'handoff',
                        'name' => 'Chapter 3: Handoff Toolkit',
                        'description' => 'Document learnings and share asynchronously.',
                        'lessons' => 3,
                        'duration' => '30 min',
                        'status' => 'locked',
                    ],
                ],
            ],
            'inclusion-labs' => [
                'id' => 'inclusion-labs',
                'title' => 'Inclusion Labs',
                'summary' => 'Micro-learning lab to amplify inclusive facilitation habits.',
                'category' => 'Culture',
                'updated' => '1 week ago',
                'duration' => '2 hours',
                'modulesCount' => 2,
                'modules' => [
                    [
                        'id' => 'language',
                        'name' => 'Chapter 1: Language Tune-Up',
                        'description' => 'Reframe everyday language and naming conventions.',
                        'lessons' => 3,
                        'duration' => '35 min',
                        'status' => 'ready',
                    ],
                    [
                        'id' => 'rituals',
                        'name' => 'Chapter 2: Meeting Rituals',
                        'description' => 'Design opening/closing rituals that invite every voice.',
                        'lessons' => 4,
                        'duration' => '45 min',
                        'status' => 'ready',
                    ],
                ],
            ],
        ];
    }
}
