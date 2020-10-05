export default {
  items: [
    {
      name: 'Caixas',
      url: '/caixa',
      icon: 'fa fa-stop',
      children: [
        {
          name: 'Cadastrar',
          url: '/caixa/cadastrar',
          icon: 'fa fa-plus'
        },
        {
          name: 'Listar',
          url: '/caixa',
          icon: 'fa fa-stop'
        },
        {
          name: 'Gerar Espelhos em Lote',
          url: '/caixa/gerar-espelho',
          icon: 'fa fa-stop'
        }
      ]
    },
    {
      name: 'Documentos',
      url: '/documento',
      icon: 'fa fa-file',
      children: [
        {
          name: 'Cadastrar',
          url: '/documento/cadastrar',
          icon: 'fa fa-plus'
        },
        {
          name: 'Listar',
          url: '/documento',
          icon: 'fa fa-file'
        },
        {
          name: 'Eliminar Documentos',
          url: '/documento/eliminar',
          icon: 'fa fa-file'
        },
        {
          name: 'Recolher Documentos',
          url: '/documento/recolher',
          icon: 'fa fa-file'
        }
      ]
    },
    {
      name: 'Cadastros',
      url: '/',
      icon: 'fa fa-file',
      children: [
        {
          name: 'Tipos Documentos',
          url: '/tipo',
          icon: 'fa fa-plus'
        },
        {
          name: 'Classificações',
          url: '/classificacao',
          icon: 'fa fa-file'
        },
      ]
    },
    {
      name: 'Listagens',
      url: '/',
      icon: 'fa fa-list',
      children: [
        {
          name: 'Eliminação',
          url: '/listagemEliminacao',
          icon: 'fa fa-list'
        },
        {
          name: 'Recolhimento',
          url: '/listagemRecolhimento',
          icon: 'fa fa-list'
        }
      ]
    },
    {
      name: 'Configuração',
      url: '/',
      icon: 'fa fa-key',
      children: [
        {
          name: 'Usuários',
          url: '/usuarios',
          icon: 'fa fa-user'
        },
        {
          name: 'Perfil',
          url: '/perfis',
          icon: 'fa fa-key'
        }
      ]
    },
  ]
}
