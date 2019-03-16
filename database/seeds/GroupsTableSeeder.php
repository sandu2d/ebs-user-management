<?php

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\Permission;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = $this->seedGroup([
            'name' => 'Administrator',
        ]);

        $group->permissions()->sync(
            Permission::all()->pluck('id')->toArray()
        );
    }

    private function seedGroup(array $data)
    {
        $group = new Group([
            'name' => $data['name'],
        ]);

        $group->save();

        return $group;
    }
}
