<x-layout>
    <x-page-heading>Register</x-page-heading>

    <x-forms.form method="POST" action="/register" enctype="multipart/form-data">
        <x-forms.input label="Name" name="name" />
        <x-forms.input type="email" label="Email" name="email" />
        <x-forms.input type="password" label="Password" name="password" />
        <x-forms.input type="password" label="Password Confirmation" name="password_confirmation" />

        <x-forms.divider />

        <x-forms.input label="Employer Name" name="employer" />
        <x-forms.input label="Logo" name="logo" type="file" />

        <x-forms.button>Create Account</x-forms.button>
    </x-forms.form>
</x-layout>
