<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro 404</title>
    <link rel="stylesheet" href="css/tailwind.css">
</head>
<body> 
    <section class="bg-base-100">
        <div class="container min-h-screen px-6 py-12 mx-auto flex justify-center lg:justify-between items-center flex-col lg:flex-row lg:gap-12">
            <div class="">
                <p class="text-sm font-medium text-primary text-center lg:text-left">Erro 404</p>
                <h1 class="mt-3 text-3xl font-semibold text-center lg:text-left">Página Não Encontrada</h1>
    
                <div class="flex lg:justify-start justify-center items-center mt-6 gap-x-3 w-full">
                    <a href="<?php echo $_SESSION['previous_url'] ?>" class="btn btn-outline flex items-center justify-center px-5 py-2 text-sm transition-colors duration-200 gap-x-2 w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l14 0" />
                            <path d="M5 12l4 4" />
                            <path d="M5 12l4 -4" />
                        </svg>
                        <span>Voltar</span>
                    </a>
    
                    <a href="index.php" class="btn btn-primary px-5 py-2 text-sm tracking-wide transition-colors duration-200 w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                        </svg>
                        Home
                    </a>
                </div>
            </div>
    
            <div class="relative w-full mt-12 lg:w-1/2 lg:mt-0 flex justify-center items-center">
                <img class="w-full max-w-lg lg:mx-auto" src="images/illustration.svg" alt="">
            </div>
        </div>
    </section>
</body>
</html>