import SiteTemplate from '@/templates/site-interno/SiteTemplate'
import Login from '@/pages/auth/Login'
import RecuperarSenha from '@/pages/auth/RecuperarSenha'
import AlterarSenha from '@/pages/auth/AlterarSenha'
import HomeExterna from '@/pages/site/externa/Home'
import HomeInterna from '@/pages/site/interna/Home'
import Usuario from '@/pages/site/interna/administrador/usuarios/Usuarios'
import UsuarioVisualizar from '@/pages/site/interna/administrador/usuarios/UsuarioVisualizar'
import UsuarioValidar from '@/pages/site/interna/administrador/usuarios/UsuarioValidar'
import UsuarioEditar from '@/pages/site/interna/administrador/usuarios/UsuarioEditar'
import UsuarioCadastrar from '@/pages/site/interna/administrador/usuarios/UsuarioCadastrar'
import MeuPerfil from '@/pages/site/interna/perfil/MeuPerfil'
import Permissoes from '@/pages/site/interna/administrador/permissoes/Permissoes'
import PermissaoCadastrar from '@/pages/site/interna/administrador/permissoes/PermissaoCadastrar'
import PermissaoEditar from '@/pages/site/interna/administrador/permissoes/PermissaoEditar'
import PermissaoVisualizar from '@/pages/site/interna/administrador/permissoes/PermissaoVisualizar'

const routes = [
  {
    path: '/',
    redirect: '/',
    name: 'Página Inicial',
    component: SiteTemplate,
    children: [
      {
        path: '/',
        component: HomeInterna
      },
      {
        path: '/usuarios',
        name: 'Usuários',
        component: Usuario
      },
      {
        path: '/usuario/:id/visualizar',
        name: 'Visualizar Usuário',
        component: UsuarioVisualizar
      },
      {
        path: '/usuario/:id/editar',
        name: 'Edição do Usuário',
        component: UsuarioEditar
      },
      {
        path: '/usuario/cadastrar',
        name: 'Cadastrar do Usuário',
        component: UsuarioCadastrar
      },
      {
        path: 'usuario/:id/validar',
        name: 'Validar Usuário',
        component: UsuarioValidar
      },
      {
        path: '/perfil',
        name: 'Meu Perfil',
        component: MeuPerfil
      },
      {
        path: 'perfis',
        name: 'Perfis',
        component: Permissoes
      },
      {
        path: 'perfil/cadastrar',
        name: 'Cadastrar Perfil',
        component: PermissaoCadastrar
      },
      {
        path: 'perfil/:id/editar',
        name: 'Editar Perfil',
        component: PermissaoEditar
      },
      {
        path: 'perfil/:id/visualizar',
        name: 'Visualizar Perfil',
        component: PermissaoVisualizar
      },

    ]
  },
  {
    path: '/login',
    component: Login
  },
  {
    path: '/recuperar-senha',
    component: RecuperarSenha
  },
  {
    path: '/alterar-senha/:token',
    component: AlterarSenha
  },
  {
    path: '/externa',
    name: 'Área Externa',
    component: HomeExterna
  }
]

export default routes
