<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        laravel: '#ef3b2d',
                    },
                },
            },
        }
    </script>
    <title>IT.IO</title>
    <style>
        body {
            margin: 0;
            overflow: hidden;
        }
        #sidebar {
            background-color: #007bff;
            color: white;
            overflow: auto;
            resize: horizontal;
            min-width: 100px;
            max-width: 400px;
            width: 200px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
        }
        .resizer {
            width: 2px;
            cursor: ew-resize;
            background-color: #ccc;
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
        }
        .content-wrapper {
            margin-left: 200px;
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }
        .content {
            flex: 1;
            overflow-y: auto;
        }
        footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 1rem;
        }
    </style>
</head>

<body>
    <div id="sidebar" class="bg-primary text-white">
        <a href="/"><img class="w-24" src="{{asset('images/logo.png')}}" alt="" class="logo" /></a>
        <ul class="flex space-x-6 mr-6 text-lg">
            @auth
            <li>
                <span class="font-bold uppercase">
                Welcome {{auth()->user()->name}}
                </span>
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px;">
            </li>
            <li>
                <a href="/listings/manage" class="hover:text-laravel"><i class="fa-solid fa-gear"></i> Manage Listings</a>
            </li>
            <li>
                <form class="inline" method="POST" action="/logout">
                @csrf
                <button type="submit">
                    <i class="fa-solid fa-door-closed"></i> Logout
                </button>
                </form>
            </li>
            @else
            <li>
                <a href="/register" class="hover:text-laravel"><i class="fa-solid fa-user-plus"></i> Register</a>
            </li>
            <li>
                <a href="/login" class="hover:text-laravel"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</a>
            </li>
            @endauth
        </ul>
        <div class="resizer" id="resizer"></div>
    </div>

    <main>
        <div class="content-wrapper">
            <div class="content">
                {{$slot}}
                
                <footer>
                    <p class="ml-2">Copyright &copy; 2022, All Rights reserved</p>
                    <a href="/listings/create" class="absolute top-1/3 right-10 bg-black text-white py-2 px-5">Post Job</a>
                </footer>
            </div>
        </div>
    </main>
    
    <x-flash-message />
</body>

<script>
    const sidebar = document.getElementById('sidebar');
    const resizer = document.getElementById('resizer');
    const contentWrapper = document.querySelector('.content-wrapper');
    const footer = document.querySelector('footer');

    resizer.addEventListener('mousedown', (event) => {
        event.preventDefault();

        const startX = event.clientX;
        const startWidth = sidebar.offsetWidth;

        const onMouseMove = (e) => {
            const newWidth = startWidth + (e.clientX - startX);
            if (newWidth >= 100 && newWidth <= 400) {
                sidebar.style.width = `${newWidth}px`;
                contentWrapper.style.marginLeft = `${newWidth}px`;
                footer.style.left = `${newWidth}px`;
            }
        };

        const onMouseUp = () => {
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
        };

        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);
    });
</script>

</html>