<?php

namespace AppBundle\Util;

use Symfony\Component\Routing\RouterInterface;

class Menu
{
    public static function getMenu($utilisateur, $securityAuthorizationChecker, $router)
    {
        $acceuil = array(
                'libelle' => 'Accueil',
                'icone' => 'fa-home',
                'href' => 'accueil',
                'routes' => array('accueil'),
                'active' => false,
                'sousMenu' => null,
        );

        $ministeres = array(
                'libelle' => 'Ministères',
                'icone' => 'fa-bank',
                'href' => 'ministere',
                'routes' => array('ministere', 'show_ministere', 'new_ministere', 'edit_ministere'),
                'active' => false,
                'sousMenu' => null,
        );

        $rlc = array(
                'libelle' => 'RLC',
                'icone' => 'fa-user',
                'href' => 'rlc_index',
                'routes' => array('rlc_index', 'rlc_edit', 'rlc_new'),
                'active' => false,
                'sousMenu' => null,
        );

        $perimetresRlc = array(
                'libelle' => 'Périmètres',
                'icone' => 'fa-share-alt',
                'href' => 'perimetre_rlc_index',
                'routes' => array('perimetre_rlc_index', 'perimetre_rlc_new', 'perimetre_rlc_edit', 'perimetre_rlc_show'),
                'active' => false,
                'sousMenu' => null,
        );

        $brhp = array(
                'libelle' => 'BRHP',
                'icone' => 'fa-user',
                'href' => 'brhp_index',
                'routes' => array('brhp_index', 'brhp_new', 'brhp_edit'),
                'active' => false,
                'sousMenu' => null,
        );

        $brhpConsult = array(
                'libelle' => 'BRHP consultation',
                'icone' => 'fa-user',
                'href' => 'brhp_consult_index',
                'routes' => array('brhp_consult_index', 'brhp_consult_new', 'brhp_consult_edit'),
                'active' => false,
                'sousMenu' => null,
        );

        $perimetresBrhp = array(
                'libelle' => 'Périmètres',
                'icone' => 'fa-share-alt',
                'href' => 'perimetre_brhp_index',
                'routes' => array('perimetre_brhp_index', 'perimetre_brhp_new', 'perimetre_brhp_edit', 'perimetre_brhp_show'),
                'active' => false,
                'sousMenu' => null,
        );

        $utilisateurs = array(
                'libelle' => 'Utilisateurs',
                'icone' => 'fa-group',
                'href' => 'utilisateur_index',
                'routes' => array('utilisateur_index', 'utilisateur_new'),
                'active' => false,
                'sousMenu' => null,
        );

        $campagnesPNC = array(
                'libelle' => 'Campagnes',
                'icone' => 'fa-circle-o-notch',
                'href' => 'campagne_pnc_index',
                'routes' => array('campagne_pnc_index', 'campagne_pnc_edit', 'campagne_pnc_new', 'campagne_pnc_show'),
                'active' => false,
                'sousMenu' => null,
        );

        $campagnesAdminMin = array(
            'libelle' => 'Campagnes',
            'icone' => 'fa-circle-o-notch',
            'href' => 'campagne_admin_min_index',
            'routes' => array('campagne_admin_min_index', 'campagne_admin_min_show'),
            'active' => false,
            'sousMenu' => null,
        );

        $campagnesBRHP = array(
                'libelle' => 'Campagnes',
                'icone' => 'fa-circle-o-notch',
                'href' => 'campagne_brhp_index',
                'routes' => array('campagne_brhp_index', 'campagne_brhp_show', 'campagne_upload', 'campagne_brhp_edit'),
                'active' => false,
                'sousMenu' => null,
        );

        $campagnesRLC = array(
                'libelle' => 'Campagnes',
                'icone' => 'fa-circle-o-notch',
                'href' => 'campagne_rlc_index',
                'routes' => array('campagne_rlc_index', 'campagne_rlc_edit', 'campagne_rlc_new', 'campagne_rlc_show'),
                'active' => false,
                'sousMenu' => null,
        );

        $campagnesSHD = array(
                'libelle' => 'Campagnes',
                'icone' => 'fa-circle-o-notch',
                'href' => 'campagne_shd_index',
                'routes' => array('campagne_shd_index', 'campagne_shd_show', 'campagne_show_listes_shd', 'crep_show', ' crep_edit'),
                'active' => false,
                'sousMenu' => null,
        );

        $campagnesAH = array(
            'libelle' => 'Campagnes',
            'icone' => 'fa-circle-o-notch',
            'href' => 'campagne_ah_index',
            'routes' => array('campagne_ah_index', 'campagne_ah_show', 'crep_show'),
            'active' => false,
            'sousMenu' => null,
        );

        $campagnesAgent = array(
            'libelle' => 'Campagnes',
            'icone' => 'fa-circle-o-notch',
            'href' => 'campagne_agent_index',
            'routes' => array('campagne_agent_index', 'campagne_agent_show', 'crep_show'),
            'active' => false,
            'sousMenu' => null,
        );

        $organisation = array(
            'libelle' => 'Organisation',
            'icone' => 'fa-sitemap',
            'href' => 'unite_organisationnelle_index',
            'routes' => array('unite_organisationnelle_index', 'unite_organisationnelle_show', 'unite_organisationnelle_new', 'unite_organisationnelle_edit'),
            'active' => false,
            'sousMenu' => null,
        );

        $formation = array(
                'libelle' => 'Référentiel formation',
                'icone' => 'fa-graduation-cap',
                'href' => 'formation_index',
                'routes' => array('formation_index', 'formation_show', 'formation_new', 'formation_edit', 'formation_upload'),
                'active' => false,
                'sousMenu' => null,
        );

        $menu = array();
        $menu[] = $acceuil;

        if ($securityAuthorizationChecker->isGranted('ROLE_ADMIN')) {
            $perimetresRlc = array(
                'libelle' => 'Périmètres RLC',
                'icone' => 'fa-share-alt',
                'href' => 'perimetre_rlc_index',
                'routes' => array('perimetre_rlc_index', 'perimetre_rlc_new', 'perimetre_rlc_edit', 'perimetre_rlc_show'),
                'active' => false,
                'sousMenu' => null,
            );

            $perimetresBrhp = array(
                'libelle' => 'Périmètres BRHP',
                'icone' => 'fa-share-alt',
                'href' => 'perimetre_brhp_index',
                'routes' => array('perimetre_brhp_index', 'perimetre_brhp_new', 'perimetre_brhp_edit', 'perimetre_brhp_show'),
                'active' => false,
                'sousMenu' => null,
            );

            $perimetres = array(
                'libelle' => 'Périmètres',
                'icone' => 'fa-share-alt',
                'routes' => array('perimetre_rlc_index', 'perimetre_rlc_new', 'perimetre_rlc_edit', 'perimetre_rlc_show'),
                'active' => false,
                'sousMenu' => array($perimetresRlc, $perimetresBrhp),
            );

            $acteursRh = array(
                'libelle' => 'Acteurs RH',
                'icone' => 'fa-user',
                'routes' => array(),
                'active' => false,
                'sousMenu' => array($rlc, $brhp, $brhpConsult),
            );

            $campagnesPNC = array(
                'libelle' => 'Campagnes PNC',
                'icone' => 'fa-circle-o-notch',
                'href' => 'campagne_pnc_index',
                'routes' => array('campagne_pnc_index', 'campagne_pnc_edit', 'campagne_pnc_new', 'campagne_pnc_show'),
                'active' => false,
                'sousMenu' => null,
            );

            $campagnesRLC = array(
                'libelle' => 'Campagnes RLC',
                'icone' => 'fa-circle-o-notch',
                'href' => 'campagne_rlc_index',
                'routes' => array('campagne_rlc_index', 'campagne_rlc_edit', 'campagne_rlc_new', 'campagne_rlc_show'),
                'active' => false,
                'sousMenu' => null,
            );

            $campagnesBRHP = array(
                'libelle' => 'Campagnes BRHP',
                'icone' => 'fa-circle-o-notch',
                'href' => 'campagne_brhp_index',
                'routes' => array('campagne_brhp_index', 'campagne_brhp_show', 'campagne_upload', 'campagne_brhp_edit'),
                'active' => false,
                'sousMenu' => null,
            );

            $campagnesSHD = array(
                'libelle' => 'Campagnes N+1',
                'icone' => 'fa-circle-o-notch',
                'href' => 'campagne_shd_index',
                'routes' => array('campagne_shd_index', 'campagne_shd_show', 'campagne_show_listes_shd', 'crep_show', ' crep_edit'),
                'active' => false,
                'sousMenu' => null,
            );

            $campagnesAH = array(
                'libelle' => 'Campagnes N+2',
                'icone' => 'fa-circle-o-notch',
                'href' => 'campagne_ah_index',
                'routes' => array('campagne_ah_index', 'campagne_ah_show', 'crep_show'),
                'active' => false,
                'sousMenu' => null,
            );

            $campagnesAgent = array(
                'libelle' => 'Campagnes Agent',
                'icone' => 'fa-circle-o-notch',
                'href' => 'campagne_agent_index',
                'routes' => array('campagne_agent_index', 'campagne_agent_show', 'crep_show'),
                'active' => false,
                'sousMenu' => null,
            );

            $campagnes = array(
                'libelle' => 'Campagnes',
                'icone' => 'fa-circle-o-notch',
                'routes' => array(),
                'active' => false,
                'sousMenu' => array($campagnesPNC, $campagnesRLC, $campagnesBRHP, $campagnesAH, $campagnesSHD, $campagnesAgent),
            );

            $modelesCrep = array(
                    'libelle' => 'Modèles CREP',
                    'icone' => 'fa-file-text-o',
                    'href' => 'modelecrep_index',
                    'routes' => self::getRoutes($router, 'modelecrep'),
                    'active' => false,
                    'sousMenu' => null,
            );

            $menu[] = $ministeres;
            $menu[] = $utilisateurs;
            $menu[] = $perimetres;
            $menu[] = $acteursRh;
            $menu[] = $campagnes;
            $menu[] = $modelesCrep;
        } elseif ($securityAuthorizationChecker->isGranted('ROLE_PNC')) {
            $menu[] = $perimetresRlc;
            $menu[] = $rlc;
            $menu[] = $campagnesPNC;
        } elseif ($securityAuthorizationChecker->isGranted('ROLE_RLC')) {
            $menu[] = $perimetresBrhp;
            $menu[] = $brhp;
            $menu[] = $brhpConsult;
            $menu[] = $campagnesRLC;
        } elseif ($securityAuthorizationChecker->isGranted('ROLE_BRHP') || $securityAuthorizationChecker->isGranted('ROLE_BRHP_CONSULT')) {
            $menu[] = $perimetresBrhp;
            $menu[] = $campagnesBRHP;
        } elseif ($securityAuthorizationChecker->isGranted('ROLE_SHD')) {
            $menu[] = $campagnesSHD;
        } elseif ($securityAuthorizationChecker->isGranted('ROLE_AH')) {
            $menu[] = $campagnesAH;
        } elseif ($securityAuthorizationChecker->isGranted('ROLE_AGENT')) {
            $menu[] = $campagnesAgent;
        } elseif ($securityAuthorizationChecker->isGranted('ROLE_ADMIN_MIN')) {
            $menu[] = $organisation;
            $menu[] = $formation;
            $menu[] = $campagnesAdminMin;
            $menu[] = $utilisateurs;
        }

        return $menu;
    }

    public static function setActiveMenu($route, &$menu)
    {
        foreach ($menu as &$item) {
            self::calculItemActif($route, $item);
        }

        return $menu;
    }

    private static function calculItemActif($route, &$menu)
    {
        if (null == $menu['sousMenu']) {
            $menu['active'] = in_array($route, $menu['routes']);

            return $menu['active'];
        } else {
            $is_active = false;

            foreach ($menu['sousMenu'] as &$item) {
                $is_active = $is_active || self::calculItemActif($route, $item);
            }
            $menu['active'] = $is_active;

            return $is_active;
        }
    }

    public static function getPathMenu($menu, &$breadCrumb = array())
    {
        foreach ($menu as &$item) {
            if (true === $item['active']) {
                if (0 != strcmp($item['libelle'], 'Accueil')) {
                    if (isset($item['routes'][0])) {
                        $route = $item['routes'][0];
                    } else {
                        $route = null;
                    }

                    $breadCrumb[] = array('libelle' => $item['libelle'], 'route' => $route);
                }
                if (null !== $item['sousMenu']) {
                    Menu::getPathMenu($item['sousMenu'], $breadCrumb);
                }
            }
        }

        return $breadCrumb;
    }

    private static function getRoutes(RouterInterface $router, $suffixe)
    {
        $routes = array();

        $allRoutes = $router->getRouteCollection()->all();

        foreach ($allRoutes as $nom_route => $objet_route) {
            $tab_route = explode('_', $nom_route);

            if (end($tab_route) == $suffixe) {
                $routes[] = $nom_route;
            }
        }

        return $routes;
    }
}
