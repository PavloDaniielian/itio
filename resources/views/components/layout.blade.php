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
        #sidebar-logo {
            background-color: #0d0c0f;
            overflow: auto;
            width: 45vw;
            height: 100vh;
            position: fixed;
        }
        #sidebar {
            background-color: #080829;
            overflow: auto;
            resize: horizontal;
            min-width: 100px;
            max-width: 400px;
            width: 300px;
            height: 100vh;
            position: fixed;
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
            margin-left: 300px;
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }
        .content-wrapper-logo {
            margin-left: 45vw;
        }
        .content {
            flex: 1;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    @auth
    <div id="sidebar" class="text-white p-6">
        <div class="text-3xl font-bold uppercase mb-1 text-decoration-underline" style="text-align:left;">IT.IO</div>
        <ul class="flex space-x-6 mr-6 text-lg">
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
        </ul>
        <div class="resizer" id="resizer"></div>
    </div>
    <main>
        <div class="content-wrapper">
            
    @else
    <div id="sidebar-logo" class="text-white p-10">
        <div class="text-3xl font-bold uppercase mb-1 text-decoration-underline" style="text-align:left;">IT.IO</div>
        <div style="text-align: -webkit-center;">
            <img class="mt-8" style="max-height:60vh;" src="images/splash.webp" />
        </div>
        <div class="text-2xl text-center mt-8">Post Job! Find Talent!</div>
        <div class="text-xs text-center mt-8">Copyright &copy; 2022, All Rights reserved</div>
    </div>
    <main>
        <div class="content-wrapper content-wrapper-logo">
    @endauth
    
            <div class="content">
                {{$slot}}
            </div>
        </div>
    </main>
    
    <x-flash-message />
</body>

<script>
    const sidebar = document.getElementById('sidebar');
    const resizer = document.getElementById('resizer');
    const contentWrapper = document.querySelector('.content-wrapper');
    //const footer = document.querySelector('footer');

    resizer.addEventListener('mousedown', (event) => {
        event.preventDefault();

        const startX = event.clientX;
        const startWidth = sidebar.offsetWidth;

        const onMouseMove = (e) => {
            const newWidth = startWidth + (e.clientX - startX);
            if (newWidth >= 100 && newWidth <= 400) {
                sidebar.style.width = `${newWidth}px`;
                contentWrapper.style.marginLeft = `${newWidth}px`;
                //footer.style.left = `${newWidth}px`;
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