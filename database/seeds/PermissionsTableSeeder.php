<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedPermision([
            'Edit users',
            'users.edit'
        ]);

        $this->seedPermision([
            'Delete users',
            'users.delete'
        ]);

        $this->seedPermision([
            'Create users',
            'users.create'
        ]);

        $this->seedPermision([
            'Block users',
            'users.block'
        ]);

        $this->seedPermision([
            'Activate users',
            'users.activate'
        ]);

        $this->seedPermision([
            'Change users group',
            'users.group.change'
        ]);

        $this->seedPermision([
            'Create group',
            'group.create'
        ]);

        $this->seedPermision([
            'Edit group',
            'group.edit'
        ]);

        $this->seedPermision([
            'Delete group',
            'group.delete'
        ]);

        $this->seedPermision([
            'Sync group permissions',
            'group.permissions'
        ]);
    }

    private function seedPermision(array $data)
    {
        $permission = new Permission([
            'name' => $data[0],
            'code' => $data[1],
        ]);

        $permission->save();

        return $permission;
    }
}
