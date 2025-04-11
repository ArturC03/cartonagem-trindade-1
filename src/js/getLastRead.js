let registros = []; // Armazena os dados recebidos
let currentIndex = 0; // Para controlar o índice dos registros
let lastFetchTime = null; // Para armazenar a última vez que os dados foram recebidos
let tempoSemDados = 0; // Variável para contar o tempo sem dados
let timeoutRef = null; // Para guardar a referência do timeout

// Inicializando as variáveis de último data e hora com valores iniciais
let ultimoData = '2025-04-11';  // Defina aqui a data inicial
let ultimoHora = '09:38:00';   // Defina aqui a hora inicial

async function verificaNovosRegistos() {
  try {
    const url = `${window.location.origin}/cartonagem-trindade-25/backend/get_last_sensor_reading.php?last_date=${ultimoData}&last_time=${ultimoHora}`;
    const resposta = await fetch(url);
    const dados = await resposta.json();

    console.log("Dados recebidos", dados);

    // Caso dados sejam recebidos
    if (dados.success && dados.data.length > 0) {
      // Armazena os registros recebidos
      registros = dados.data;

      // Exibe o primeiro registro
      currentIndex = 0; // Resetando o índice ao receber novos dados
      exibirRegistro();

      // Atualiza a última data e hora
      ultimoData = registros[registros.length - 1].date;
      ultimoHora = registros[registros.length - 1].time;

      // Atualiza a última hora da requisição bem-sucedida
      lastFetchTime = new Date(); // Atualiza o tempo da última resposta

      // Reset tempo sem dados
      tempoSemDados = 0;

      // Exibe mensagem padrão de recebimento de dados
      // document.getElementById('paragrafo').textContent = "Dados recebidos, aguardando novo dado em 2 minutos...";
      // document.getElementById('paragrafo').classList.remove('text-red-500', 'font-bold');
      // document.getElementById('paragrafo').classList.add('text-green-500');
      
      // Após os dados serem recebidos, aguarda 2 minutos para buscar novamente
      if (timeoutRef) clearTimeout(timeoutRef);
      timeoutRef = setTimeout(verificaNovosRegistos, 120000); // 2 minutos

    } else {
      // Caso não haja dados
      if (lastFetchTime) {
        tempoSemDados = Math.floor((new Date() - lastFetchTime) / 1000); // Tempo em segundos

        // Se passou mais de 2 minutos sem dados, mostra mensagem de alerta
        if (tempoSemDados >= 120) {
          document.getElementById('paragrafo').textContent = `Atenção! Mais de 2 minutos sem novos dados.`;
          // document.getElementById('paragrafo').classList.add('text-red-500', 'font-bold'); // Mensagem em vermelho
        } else {
          document.getElementById('paragrafo').textContent = `Nenhum novo dado encontrado. Tempo sem dados: ${tempoSemDados} segundos.`;
          // document.getElementById('paragrafo').classList.remove('text-red-500', 'font-bold');
          // document.getElementById('paragrafo').classList.add('text-yellow-500'); // Mensagem amarela
        }
      } else {
        // Caso ainda não tenha sido feito um fetch
        document.getElementById('paragrafo').textContent = "A carregar...";
        // document.getElementById('paragrafo').classList.remove('text-red-500', 'font-bold');
      }
    }

  } catch (error) {
    console.error("Erro ao buscar dados:", error);
    document.getElementById('paragrafo').textContent = "Erro ao buscar dados";
    // document.getElementById('paragrafo').classList.add('text-red-500', 'font-bold'); // Mensagem de erro em vermelho
  }

  // Chama a função novamente após 500ms para verificar o tempo sem dados
  setTimeout(verificaNovosRegistos, 500);
}

// Função para exibir os registros de um em um
function exibirRegistro() {
  if (currentIndex < registros.length) {
    const campos = registros[currentIndex];

    // Junta todos os valores dos campos numa só string
    const texto = Object.values(campos).join(' ');

    // Atualiza o texto do parágrafo com o novo registro
    document.getElementById('paragrafo').textContent = texto;

    // Aumenta o índice para o próximo registro
    currentIndex++;

    // Chama essa função novamente após 1000ms (1 segundo) para exibir o próximo registro
    setTimeout(exibirRegistro, 1000);
  } else {
    // Quando todos os registros forem exibidos, exibe a mensagem padrão
    document.getElementById('paragrafo').textContent = "Dados recebidos, aguardando novo dado em 2 minutos...";
  }
}

// Inicia a verificação
verificaNovosRegistos();