<template>
  <div class="app">
    <AppHeader fixed>
      <SidebarToggler class="d-lg-none" display="md" mobile />
      <b-link class="navbar-brand" to="/">
        <h6 class="navbar-brand-full" width="50" height="25" alt="DOC MMFDH">DOC MMFDH</h6>
      </b-link>
      <SidebarToggler class="d-md-down-none" display="lg" />
      <b-navbar-nav class="ml-auto">
        <b-nav-item class="d-md-down-none">
        </b-nav-item>
        <DefaultHeaderDropdownAccnt/>
      </b-navbar-nav>
      <!--<AsideToggler class="d-none d-lg-block" />-->
     <!--<AsideToggler class="d-lg-none" mobile />-->
    </AppHeader>
    <div class="app-body">
      <AppSidebar fixed>
        <SidebarHeader/>
        <SidebarForm/>
        <SidebarNav :navItems="nav"></SidebarNav>
        <SidebarFooter/>
        <SidebarMinimizer/>
      </AppSidebar>
      <main class="main">
        <Breadcrumb :list="list"/>
        <div class="container-fluid">
          <router-view></router-view>
        </div>
      </main>
     <!-- <AppAside fixed>
        &lt;!&ndash;aside&ndash;&gt;
        <DefaultAside/>
      </AppAside>-->
    </div>
    <TheFooter>
      <!--footer-->
      <div>
        <span class="ml-1">DOC MMFDH &copy; 2020</span>
      </div>
    </TheFooter>
  </div>
</template>

<script>
import nav from '@/_nav'
import { Header as AppHeader, SidebarToggler, Sidebar as AppSidebar, SidebarFooter, SidebarForm, SidebarHeader, SidebarMinimizer, SidebarNav, Aside as AppAside, AsideToggler, Footer as TheFooter, Breadcrumb } from '@coreui/vue'
import DefaultAside from '@/templates/containers/DefaultAside'
import DefaultHeaderDropdown from '@/templates/containers/DefaultHeaderDropdown'
import DefaultHeaderDropdownAccnt from '@/templates/containers/DefaultHeaderDropdownAccnt'
import DefaultHeaderDropdownMssgs from '@/templates/containers/DefaultHeaderDropdownMssgs'
import DefaultHeaderDropdownTasks from '@/templates/containers/DefaultHeaderDropdownTasks'
import SessionStorage from '@/services/session-storage'

export default {
  name: 'SiteTemplate',
  components: {
    AsideToggler,
    AppHeader,
    AppSidebar,
    AppAside,
    TheFooter,
    Breadcrumb,
    DefaultAside,
    DefaultHeaderDropdown,
    DefaultHeaderDropdownMssgs,
    DefaultHeaderDropdownTasks,
    DefaultHeaderDropdownAccnt,
    SidebarForm,
    SidebarFooter,
    SidebarToggler,
    SidebarHeader,
    SidebarNav,
    SidebarMinimizer
  },
  created () {
    let usuario = SessionStorage.get('usuario')

    if (!usuario) {
      this.$router.push('/login')
    }
    this.$store.dispatch('atualizarPermissoes')
  },
  computed: {
    nav () {
      let news = []
      let configuracoes = [];
      if(this.can('usuario.index') || this.can('perfil.index')){
        configuracoes =  {
          name: 'Configuração',
          url: '/',
          icon: 'fa fa-key',
          children: [

          ]
        };
        configuracoes.children.push({
            name: 'Usuários',
            url: '/usuarios',
            icon: 'fa fa-user'
        });
        configuracoes.children.push(  {
            name: 'Perfil',
            url: '/perfis',
            icon: 'fa fa-key'
        });
        news.push(configuracoes)
      }

      return news
    },
    computedNav () {
      return this.nav.filter((item) => console.log(item.name) )
    },
    name () {
      return this.$route.name
    },
    list () {
      return this.$route.matched.filter((route) => route.name || route.meta.label)
    }
  },
  methods: {
    can (permissao) {
      return this.$store.getters.validaPermissao(permissao)
    }
  }
}
</script>

<style lang="scss" scoped>
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
