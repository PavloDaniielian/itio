<x-layout>
  <x-card class="p-10 max-w-lg mx-auto">
    <header class="text-center">
      <h2 class="text-2xl font-bold uppercase mb-1">Register</h2>
      <p class="mb-4">Create an account to post gigs</p>
    </header>

    <form method="POST" action="/users" enctype="multipart/form-data">
      @csrf
      <div class="mb-6">
        <label for="name" class="inline-block text-lg mb-2"> Name </label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name" value="{{old('name')}}" />

        @error('name')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="email" class="inline-block text-lg mb-2">Email</label>
        <input type="email" class="border border-gray-200 rounded p-2 w-full" name="email" value="{{old('email')}}" />

        @error('email')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="password" class="inline-block text-lg mb-2">
          Password
        </label>
        <input type="password" class="border border-gray-200 rounded p-2 w-full" name="password"
          value="{{old('password')}}" />

        @error('password')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="password2" class="inline-block text-lg mb-2">
          Confirm Password
        </label>
        <input type="password" class="border border-gray-200 rounded p-2 w-full" name="password_confirmation"
          value="{{old('password_confirmation')}}" />

        @error('password_confirmation')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <label for="avatar-upload" class="inline-block text-lg mb-2">Avatar</label>
      <div class="mb-6 avatar-preview-container">
        <input type="file" class="form-control" id="avatar-upload" name="avatar" accept="image/*">
        <div id="avatar-preview">
          <img src="" alt="Avatar Preview" id="avatar-img" style="display:none;" />
          <div id="avatar-alt" style="margin-top:20px;">No<BR>Avatar</div>
        </div>
        @error('avatar')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6 text-center">
        <button type="submit" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
          Sign Up
        </button>
      </div>

      <div class="mt-8 text-center">
        <p>
          Already have an account?
          <a href="/login" class="text-laravel">Login</a>
        </p>
      </div>
    </form>
  </x-card>
</x-layout>

<style>
  .avatar-preview-container {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  #avatar-preview {
    margin-top: 10px;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #ccc;
    text-align: center;
  }

  #avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
</style>

<script>
  document.getElementById("avatar-upload").addEventListener("change", function(event) {
    const file = event.target.files[0];
    const avatarImg = document.getElementById("avatar-img");
    const avatarAlt = document.getElementById("avatar-alt");
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const avatarImg = document.getElementById("avatar-img");
        avatarImg.src = e.target.result;
        avatarAlt.style.display = "none";
      };
      avatarImg.style.display = "block";
      avatarAlt.innerHTML = "<BR>Loading"
      avatarAlt.style.display = "block";
      reader.readAsDataURL(file);
    }else{
      avatarImg.style.display = "none";
      avatarAlt.innerHTML = "No<BR>Avatar"
      avatarAlt.style.display = "block";
    }
  });
</script>