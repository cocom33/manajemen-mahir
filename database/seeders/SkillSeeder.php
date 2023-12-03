<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            'PHP',
            'JavaScript',
            'Python',
            'Java',
            'C#',
            'Ruby',
            'Swift',
            'HTML',
            'CSS',
            'C++',
            'Objective-C',
            'TypeScript',
            'SQL',
            'Node.js',
            'React',
            'Angular',
            'Vue.js',
            'Laravel',
            'Django',
            'Flask',
            'Spring Framework',
            'ASP.NET',
            'Ruby on Rails',
            'Express.js',
            'jQuery',
            'Bootstrap',
            'Sass',
            'Less',
            'GraphQL',
            'RESTful API',
            'Git',
            'GitHub',
            'GitLab',
            'Bitbucket',
            'Docker',
            'Kubernetes',
            'AWS',
            'Azure',
            'Google Cloud Platform',
            'Firebase',
            'MongoDB',
            'MySQL',
            'PostgreSQL',
            'Redis',
            'GraphQL',
            'D3.js',
            'Webpack',
            'Babel',
            'Jenkins',
            'Travis CI',
            'JIRA',
            'Confluence',
            'Agile',
            'Scrum',
            'Kanban',
        ];

        foreach ($skills as $skill) {
            DB::table('skills')->insert([
                'name' => $skill,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
