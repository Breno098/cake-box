<?php

namespace App\Helpers\Seeder;

use Illuminate\Support\Arr;

class Random
{
    /**
     * Links de imagens online para testes de banco de dados
     *
     * @return string
     */
    public static function image(): string
    {
        return Arr::random([
            'https://centralblogs.com.br/wp-content/uploads/2019/12/banana-com-chocolate.jpg',
            'https://static.stealthelook.com.br/wp-content/uploads/2022/08/receitas-com-cafe-nada-obvias-para-preparar-de-manha-smoothie-de-cafe-20220819175726.jpg',
            'https://melhorcomsaude.com.br/wp-content/uploads/2018/05/5-receitas-com-caf%C3%A9-que-voc%C3%AA-n%C3%A3o-conhecia-768x491.jpg',
            'https://www.dia.com.br/static/39142edc1ebfa7327b1bedc472220240/ec413/28.jpg',
            'https://s2.glbimg.com/WEF_MgZ7NrunOQhc-ZCcEmvwSRQ=/620x620/smart/e.glbimg.com/og/ed/f/original/2022/08/19/5-receitas-mais-buscadas-pelos-brasileiros-pudim-de-leite-em-po.png',
            'https://s2.glbimg.com/AXaoYCopgcL0wELPkAR1fdtjYSI=/0x0:1080x608/924x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_e84042ef78cb4708aeebdf1c68c6cbd6/internal_photos/bs/2022/f/X/zBfiNAR8KZu6QgTgQnSg/capa-materia-gshow-2022-01-15t154112.695.png',
            'https://p2.trrsf.com/image/fget/cf/774/0/images.terra.com/2023/01/30/1515805958-espaguete-ao-molho-pesto-esta-entre-as-receitas-vegetarianas-faceis.jpg',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRpgwg4tMQaYjMocbd1GUFO2nBb0ESKFZYlq5jgCTGfKGkUJVQwoJ_uDq_EI25CBGuuPMQ&usqp=CAU',
            'https://www.receiteria.com.br/wp-content/uploads/receitas-fit.jpg',
            'https://static1.conquistesuavida.com.br/articles//4/12/67/4/@/31565-uma-das-receitas-fitness-mais-indicadas-article_block_media-2.jpg',
            'https://s2.glbimg.com/L2B4EizERGlXumtyQaZTRopnrbs=/0x0:983x732/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_1f540e0b94d8437dbbc39d567a1dee68/internal_photos/bs/2021/n/R/iRqbSuQ1C7PdX0uZGljQ/panqueca-fit-receita-saudavel-simples-facil.jpeg',
            'https://blog.livup.com.br/wp-content/uploads/2021/11/receitas-de-lanches-fitness-principal.jpg',
            'https://receitasgourmetdavovo.com.br/wp-content/uploads/2022/05/calzone-fit.jpg.webp',
            'https://www.dicasdemulher.com.br/wp-content/uploads/2021/04/receitas-fit-faceis-0.png',
            'https://sportlife.com.br/wp-content/uploads/2021/06/complexob.jpg',
            'https://lojamarombada.com/wp-content/uploads/2018/08/receitas-fitness.jpg',
            'https://www.hipertrofia.org/blog/wp-content/uploads/2020/05/hamburguer-de-frango-com-aveia.jpg',
            'https://receitasgourmetdavovo.com.br/wp-content/uploads/2022/05/hamburguer-de-vegetais.jpg',
        ]);
    }
}
