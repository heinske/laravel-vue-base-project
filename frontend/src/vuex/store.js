import Pagination from '@/vuex/modules/pagination'
import Usuario from '@/vuex/modules/usuario'
import Perfil from '@/vuex/modules/perfil'
import Nacionalidade from '@/vuex/modules/nacionalidade'
import Palestrante from '@/vuex/modules/palestrante'
import Participante from '@/vuex/modules/participante'
import Caixa from '@/vuex/modules/caixa'
import Evento from '@/vuex/modules/eventos'
import Estado from '@/vuex/modules/estado'
import Cidade from '@/vuex/modules/cidade'
import Modulo from '@/vuex/modules/modulo'
import Permissao from '@/vuex/modules/permissao'
import TokenEmail from '@/vuex/modules/token'
import Classificacao from '@/vuex/modules/classificacao'
import TipoDocumento from '@/vuex/modules/tipoDocumento'
import TipoObjeto from '@/vuex/modules/tipoObjeto'
import SituacaoDocumento from '@/vuex/modules/situacaoDocumento'
import Documento from '@/vuex/modules/documento'
import ListagemEliminacao from '@/vuex/modules/listagemEliminacao'
import ListagemRecolhimento from '@/vuex/modules/listagemRecolhimento'
import GeneroListagemRecolhimento from '@/vuex/modules/generoListagemRecolhimento'
import SituacaoListagemRecolhimento from '@/vuex/modules/situacaoListagemRecolhimento'
import SituacaoListagemEliminacao from '@/vuex/modules/situacaoListagemEliminacao'

export default {
  modules: {
    usuario: Usuario,
    nacionalidade: Nacionalidade,
    estado: Estado,
    cidade: Cidade,
    palestrante: Palestrante,
    participante: Participante,
    evento: Evento,
    token: TokenEmail,
    pagination: Pagination,
    modulo: Modulo,
    permissao: Permissao,
    perfil: Perfil,
    caixa: Caixa,
    classificacao: Classificacao,
    tipoDocumento: TipoDocumento,
    tipoObjeto: TipoObjeto,
    situacaoDocumento: SituacaoDocumento,
    documento: Documento,
    listagemEliminacao: ListagemEliminacao,
    listagemRecolhimento: ListagemRecolhimento,
    situacaoListagemEliminacao: SituacaoListagemEliminacao,
    situacaoListagemRecolhimento: SituacaoListagemRecolhimento,
    generoListagemRecolhimento: GeneroListagemRecolhimento

  }
}
