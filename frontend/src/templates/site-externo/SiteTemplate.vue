<template>
  <!--==========================
Header
============================-->
  <span>

    <header id="header">
    <div class="container">

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="#intro">Página Inicial</a></li>
          <li><a href="#about">O que fazer</a></li>
          <li><a href="#faq">Perguntas e Respostas</a></li>
           <li><a href="#legislacao">Legislação</a></li>
          <!-- <li class="buy-tickets"><a href="#buy-tickets">Buy Tickets</a></li> -->
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--==========================
    Intro Section
  ============================-->
  <section id="intro">
    <div class="intro-container wow fadeIn">
      <p class="mb-4 pb-0">Cadastro Nacional de</p>
      <h1 class="mb-4 pb-0"><span>Crianças</span> e <span class="adolecente">Adolescentes<br></span>DESAPARECIDOS</h1>
      <a href="javascript:" class="about-btn scrollto" @click="navigate('/cadastro-desaparecido')">Cadastrar Desaparecido</a>
      <a href="javascript:" class="about-btn scrollto" @click="navigate('/acompanhar-desaparecido')">Acompanhar Desaparecido</a>
      <a href="#about" class="about-btn scrollto">Baixe o aplicativo</a>
    </div>
  </section>

    <main id="main">

    <!--==========================
      About Section
    ============================-->
    <section id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2>O que fazer após o cadastro?</h2>
            <p>Verificar as informações do site <a href="https://br.globalmissingkids.org">https://br.globalmissingkids.org</a>/</p>
            <p>Pessoa desaparecida é todo ser humano cujo paradeiro é desconhecido – até que sua recuperação e identificação tenham sido confirmadas –, não importa a causa de seu desaparecimento.</p>
            <p>Atenção: é importante ter o máximo de informações possível e fornecer fotografias da criança ou adolescente desaparecido.</p>
            <ol>
              <li>No caso do desaparecimento de uma criança ou um adolescente, procure imediatamente a delegacia mais próxima de sua residência e registre o Boletim de Ocorrência.</li>
              <li>Comunique o desaparecimento da criança ou adolescente ao Conselho Tutelar de sua cidade.</li>
              <li>Registre o caso de desaparecimento no Cadastro Nacional de Crianças e <a href="/cadastro-desaparecido">Adolescentes Desaparecidos</a>. Qualquer pessoa pode fazer o registro, mesmo não sendo da família.</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section id="schedule" class="section-with-bg">
      <div class="container wow fadeInUp">
        <div class="section-header">
          <h2>Desaparecidos</h2>
          <p>Ajude a encontrar crianças e adolescentes desparecidos</p>
        </div>
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" href="#day-1" role="tab" data-toggle="tab">Download para Android   <i class="fa fa-android" aria-hidden="true"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#day-2" role="tab" data-toggle="tab">Download para Apple IOS  <i class="fa fa-apple" aria-hidden="true"></i></a>
          </li>
        </ul>
      </div>
    </section>

      <!--==========================
        F.A.Q Section
      ============================-->
    <section id="faq" class="wow fadeInUp">

      <div class="container">

        <div class="section-header">
          <h2>PERGUNTAS E RESPOSTAS</h2>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-9">
              <ul id="faq-list">

                <li>
                  <a data-toggle="collapse" class="collapsed" href="#faq1">Uma criança ou um adolescente desapareceu, o que devo fazer?<i class="fa fa-minus-circle"></i></a>
                  <div id="faq1" class="collapse" data-parent="#faq-list">
                    <p>
                      Procure a delegacia mais próxima de sua residência e registre o Boletim de Ocorrência.
                    </p>
                  </div>
                </li>

                <li>
                  <a data-toggle="collapse" href="#faq2" class="collapsed">Quanto tempo preciso esperar para procurar uma delegacia e fazer o Boletim de Ocorrência? <i class="fa fa-minus-circle"></i></a>
                  <div id="faq2" class="collapse" data-parent="#faq-list">
                    <p>
                      Não precisa esperar, procure a delegacia imediatamente para registrar o Boletim de Ocorrência. É um direito do cidadão, garantido pelo Estatuto da Criança e do Adolescente – ECA.
                    </p>
                    <p>
                      A Lei nº 11.259, de 30 de dezembro de 2005, conhecida como Lei da Busca Imediata, alterou o ECA para determinar investigação imediata em caso de desaparecimento de criança ou adolescente, após notificação aos órgãos competentes.
                    </p>
                    <p>
                      Os órgãos competentes devem comunicar o desaparecimento aos portos, aeroportos, Polícia Rodoviária e companhias de transporte interestaduais e internacionais e fornecer todos os dados necessários à identificação do desaparecido.
                    </p>
                    <p>
                      Se a polícia se negar em registrar o Boletim de Ocorrência, o que faço?
Procure o Ministério Público ou o Conselho Tutelar de sua cidade para garantir o seu direito.
                    </p>
                    <p>
                      Você também pode denunciar a violação desse direito por meio do Disque Direitos Humanos – Disque 100.
                    </p>
                  </div>
                </li>

                <li>
                  <a data-toggle="collapse" href="#faq3" class="collapsed">Se a polícia se negar em registrar o Boletim de Ocorrência, o que faço? <i class="fa fa-minus-circle"></i></a>
                  <div id="faq3" class="collapse" data-parent="#faq-list">
                    <p>
                     Procure o Ministério Público ou o Conselho Tutelar de sua cidade para garantir o seu direito.
                    </p>
                    <p>
                      Você também pode denunciar a violação desse direito por meio do Disque Direitos Humanos – Disque 100.
                    </p>
                  </div>
                </li>

                <li>
                  <a data-toggle="collapse" href="#faq4" class="collapsed">Quem pode inserir casos no Cadastro Nacional? <i class="fa fa-minus-circle"></i></a>
                  <div id="faq4" class="collapse" data-parent="#faq-list">
                    <p>
                      Qualquer pessoa pode registrar um caso de desaparecimento no Cadastro Nacional de Crianças e Adolescentes Desaparecidos.
                    </p>
                  </div>
                </li>

                <li>
                  <a data-toggle="collapse" href="#faq5" class="collapsed">Quem pode dar baixa no Cadastro Nacional caso o desaparecido seja localizado? <i class="fa fa-minus-circle"></i></a>
                  <div id="faq5" class="collapse" data-parent="#faq-list">
                    <p>
                   Após a confirmação da localização de uma criança ou adolescente desaparecido, a equipe técnica local ou nacional será a responsável pela baixa no Cadastro Nacional de Crianças e Adolescentes Desaparecidos.
                    </p>
                  </div>
                </li>

                <li>
                  <a data-toggle="collapse" href="#faq6" class="collapsed">Se o meu filho/filha que estava desaparecido retornou para casa o que devo fazer? <i class="fa fa-minus-circle"></i></a>
                  <div id="faq6" class="collapse" data-parent="#faq-list">
                    <p>
                     Se uma criança ou adolescente desaparecido retornar para casa ou for localizado, é importante ir até a delegacia onde foi feito o Boletim de Ocorrência para que seja dada a baixa no caso. Comunique também ao Conselho Tutelar da sua cidade.
                    </p>
                  </div>
                </li>

                <li>
                  <a data-toggle="collapse" href="#faq7" class="collapsed">Localizei uma criança ou adolescente registrada no Cadastro Nacional como devo proceder? <i class="fa fa-minus-circle"></i></a>
                  <div id="faq7" class="collapse" data-parent="#faq-list">
                    <p>
                     Procure imediatamente a delegacia de polícia mais próxima e informe o ocorrido dando os detalhes que presenciou. Comunique também ao Conselho Tutelar.
Se preferir, acione o Disque Direitos Humanos – Disque 100. A ligação é gratuita e sigilosa.
                    </p>
                  </div>
                </li>

                 <li>
                  <a data-toggle="collapse" href="#faq8" class="collapsed">É necessário ser da família para fazer o registro de um caso no Cadastro Nacional? <i class="fa fa-minus-circle"></i></a>
                  <div id="faq8" class="collapse" data-parent="#faq-list">
                    <p>
                    Não. Qualquer pessoa pode fazer o registro, mesmo não sendo da família. É importante ter o maior número de informações possíveis e fornecer ao menos uma fotografia da criança ou adolescente desaparecido.
                    </p>
                    <p><a href="/cadastro-desaparecido">Clique aqui</a> para registrar uma criança ou um adolescente desaparecido.</p>
                    <p>
As fotos e as informações da criança ou adolescente desaparecido serão divulgadas por meio do aplicativo Desaparecidos
                    </p>
                  </div>
                </li>

                 <li>
                  <a data-toggle="collapse" href="#faq9" class="collapsed">Posso fazer o registro no Cadastro Nacional sem ter feito ainda o Boletim de Ocorrência? <i class="fa fa-minus-circle"></i></a>
                  <div id="faq9" class="collapse" data-parent="#faq-list">
                    <p>
                    Sim. Mesmo que seja solicitado o número do Boletim de Ocorrência, isso não impede que o registro seja validado.
                    </p>
                    <p>
                      No entanto, o Cadastro Nacional de Crianças e Adolescentes Desaparecidos não substitui o Boletim de Ocorrência, instrumento que desencadeia o processo de investigação oficial para a busca e localização da pessoa desaparecida.
                    </p>
                    <p>
                      Portanto, procure imediatamente uma Delegacia de Polícia para notificar o acontecido, se possível levando fotografias recentes da criança ou adolescente desaparecido.
                    </p>
                  </div>
                </li>

                <li>
                  <a data-toggle="collapse" href="#faq10" class="collapsed">Posso não autorizar a coleta de material de DNA? <i class="fa fa-minus-circle"></i></a>
                  <div id="faq10" class="collapse" data-parent="#faq-list">
                    <p>
                    Sim. A coleta de DNA para o Banco Nacional de DNA não é condição para o registro do caso no Cadastro Nacional de Crianças e Adolescentes Desaparecidos.
                    </p>
                  </div>
                </li>

                <li>
                  <a data-toggle="collapse" href="#faq11" class="collapsed">Posso informar ao Cadastro Nacional a localização de uma criança ou adolescente desaparecido? <i class="fa fa-minus-circle"></i></a>
                  <div id="faq11" class="collapse" data-parent="#faq-list">
                    <p>
                    Sim. Se você tiver quaisquer informações, ligue imediatamente para a Polícia Militar, por meio do telefone 190. Após a confirmação da informação, o registro no Cadastro Nacional de Crianças e Adolescentes Desaparecidos será alterado de “Desaparecido” para “Encontrado”.
                    </p>
                    <p>
                      É imprescindível que seja informada a Delegacia onde foi feito o Boletim de Ocorrência para que seja possível encerrar a investigação caso a localização não tenha sido feita pela polícia.
                    </p>
                  </div>
                </li>

              </ul>
          </div>
        </div>

      </div>

    </section>

   <section id="legislacao" class="section-with-bg">
      <div class="container wow fadeInUp">
        <div class="section-header">
          <h2>Legislação</h2>
        </div>
        <ul>
            <li><b>Lei nº 8.069, de 13 de julho de 1990 </b>– Estatuto da Criança e do Adolescente</li>
            <li><b>Lei nº 12.127, de 17 de dezembro de 2009 </b>– Cadastro Nacional de Crianças e Adolescentes Desaparecidos</li>
            <li><b>Lei nº 12.393, de 4 de março de 2011 </b>– Semana de Mobilização Nacional para Busca e Defesa da Criança Desaparecida</li>
            <li><b>Lei nº 13.812, de 16 de março de 2019 </b>– Política Nacional de Busca de Pessoas Desaparecidas</li>
        </ul>
      </div>
    </section>

  </main>

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 offset-lg-3 col-md-6 offset-md-6 footer-links">
            <h4>Links Úteis</h4>
            <ul>
              <li><i class="fa fa-angle-right"></i> <a href="#">Home</a></li>
              <li><i class="fa fa-angle-right"></i> <a href="#">About us</a></li>
              <li><i class="fa fa-angle-right"></i> <a href="#">Services</a></li>
              <li><i class="fa fa-angle-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="fa fa-angle-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-contact">
            <h4>Contact Us</h4>
            <p>
              A108 Adam Street <br>
              New York, NY 535022<br>
              United States <br>
              <strong>Phone:</strong> +1 5589 55488 55<br>
              <strong>Email:</strong> info@example.com<br>
            </p>

            <div class="social-links">
              <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
              <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
              <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
              <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
              <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
            </div>

          </div>

        </div>
      </div>
    </div>
    <center>
        <div class="col-lg-3 col-md-6 footer-info">
          <br>
            <img src="/static/img/imagem.png" style="height: 45px;" alt="TheEvenet">
        </div>
    </center>
  </footer>

  <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

    </span>
</template>

<script>
import {
  Aside as AppAside,
  AsideToggler,
  Breadcrumb,
  Footer as TheFooter,
  Header as AppHeader,
  Sidebar as AppSidebar,
  SidebarFooter,
  SidebarForm,
  SidebarHeader,
  SidebarMinimizer,
  SidebarNav,
  SidebarToggler
} from '@coreui/vue'

export default {
  name: 'SiteTemplate',
  components: {
    AsideToggler,
    AppHeader,
    AppSidebar,
    AppAside,
    TheFooter,
    Breadcrumb,
    SidebarForm,
    SidebarFooter,
    SidebarToggler,
    SidebarHeader,
    SidebarNav,
    SidebarMinimizer
  },
  data () {
    return {
    }
  },
  mounted () {
    $('#barraBrasilCustom').show()
  },
  computed: {
    name () {
      return this.$route.name
    },
    list () {
      return this.$route.matched.filter((route) => route.name || route.meta.label)
    }
  },
  methods: {
    navigate (route) {
      this.$router.push(route)
    }
  }
}
</script>

<style lang="scss">
  // CoreUI Icons Set
  @import '@coreui/icons/css/coreui-icons.min.css';
  /* Import Font Awesome Icons Set */
  $fa-font-path: '~font-awesome/fonts/';
  @import '~font-awesome/scss/font-awesome.scss';
  /* Import Simple Line Icons Set */
  $simple-line-font-path: '~simple-line-icons/fonts/';
  @import '~simple-line-icons/scss/simple-line-icons.scss';
  /* Import Flag Icons Set */
  @import 'flag-icon-css/css/flag-icon.min.css';
  /* Import Bootstrap Vue Styles */
  @import 'bootstrap-vue/dist/bootstrap-vue.css';
  // Import Main styles for this application
  @import '../../assets/scss/style';
</style>
