<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 14/05/2017
 * Time: 03:43
 */

namespace AppBundle\Form;


use AppBundle\Repository\TaxrefRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom de l\'espèce :'
            ))
            ->add('family', EntityType::class, array(
                'class' => 'AppBundle\Entity\Taxref',
                'choice_label' => 'family',
                'placeholder' => 'Choisir',
                'label' => 'Famille :',
                'query_builder' => function(TaxrefRepository $repository){
                    return $repository->getFamilyList();
                },
                'choice_value' => 'family'
            ))
            ->add('department', ChoiceType::class, array(
                'label' => 'Département :',
                'choices' => $this->getDepartments(),
                'placeholder' => 'Choisir'
            ))
            ;
    }

    private function getDepartments()
    {
        $depFr = array();
        $depFr["01"] = array("regionId"=>"82", "nom"=>"Ain", "article"=>"L'", "cheflieu"=>"Bourg-en-Bresse", "habitant"=>"");
        $depFr["02"] = array("regionId"=>"22", "nom"=>"Aisne", "article"=>"L'", "cheflieu"=>"Laon", "habitant"=>"Axonais");
        $depFr["03"] = array("regionId"=>"83", "nom"=>"Allier", "article"=>"L'", "cheflieu"=>"Moulins", "habitant"=>"Bourbonnais, Élavérin");
        $depFr["04"] = array("regionId"=>"93", "nom"=>"Alpes-de-Haute-Provence", "article"=>"Les", "cheflieu"=>"Digne-les-Bains", "habitant"=>"Bas-Alpin");
        $depFr["06"] = array("regionId"=>"93", "nom"=>"Alpes-Maritimes", "article"=>"Les", "cheflieu"=>"Nice", "habitant"=>"Maralpin");
        $depFr["07"] = array("regionId"=>"82", "nom"=>"Ardèche", "article"=>"L'", "cheflieu"=>"Privas", "habitant"=>"Ardéchois");
        $depFr["08"] = array("regionId"=>"21", "nom"=>"Ardennes", "article"=>"Les", "cheflieu"=>"Charleville-Mézières", "habitant"=>"Ardennais");
        $depFr["09"] = array("regionId"=>"73", "nom"=>"Ariège", "article"=>"L'", "cheflieu"=>"Foix", "habitant"=>"Ariégeois");
        $depFr["10"] = array("regionId"=>"21", "nom"=>"Aube", "article"=>"L'", "cheflieu"=>"Troyes", "habitant"=>"Aubois");
        $depFr["11"] = array("regionId"=>"91", "nom"=>"Aude", "article"=>"L'", "cheflieu"=>"Carcassonne", "habitant"=>"Audois");
        $depFr["12"] = array("regionId"=>"73", "nom"=>"Aveyron", "article"=>"L'", "cheflieu"=>"Rodez", "habitant"=>"Aveyronnais");
        $depFr["67"] = array("regionId"=>"42", "nom"=>"Bas-Rhin", "article"=>"Le", "cheflieu"=>"Strasbourg", "habitant"=>"Bas-Rhinois");
        $depFr["13"] = array("regionId"=>"93", "nom"=>"Bouches-du-Rhône", "article"=>"Les", "cheflieu"=>"Marseille", "habitant"=>"Bucco-Rhodanien");
        $depFr["14"] = array("regionId"=>"25", "nom"=>"Calvados", "article"=>"Le", "cheflieu"=>"Caen", "habitant"=>"Calvadosien");
        $depFr["15"] = array("regionId"=>"83", "nom"=>"Cantal", "article"=>"Le", "cheflieu"=>"Aurillac", "habitant"=>"Cantalien");
        $depFr["16"] = array("regionId"=>"54", "nom"=>"Charente", "article"=>"La", "cheflieu"=>"Angoulême", "habitant"=>"Charentais");
        $depFr["17"] = array("regionId"=>"54", "nom"=>"Charente-Maritime", "article"=>"La", "cheflieu"=>"La Rochelle", "habitant"=>"Charentais-Maritime");
        $depFr["18"] = array("regionId"=>"24", "nom"=>"Cher", "article"=>"Le", "cheflieu"=>"Bourges", "habitant"=>"");
        $depFr["19"] = array("regionId"=>"74", "nom"=>"Corrèze", "article"=>"La", "cheflieu"=>"Tulle", "habitant"=>"Corrézien");
        $depFr["2A"] = array("regionId"=>"94", "nom"=>"Corse-du-Sud", "article"=>"La", "cheflieu"=>"Ajaccio", "habitant"=>"Corse");
        $depFr["21"] = array("regionId"=>"26", "nom"=>"Côte-d'Or", "article"=>"La", "cheflieu"=>"Dijon", "habitant"=>"Côte-d’Orien, Costalorien");
        $depFr["22"] = array("regionId"=>"53", "nom"=>"Côtes-d'Armor", "article"=>"Les", "cheflieu"=>"Saint-Brieuc", "habitant"=>"Costarmoricain");
        $depFr["23"] = array("regionId"=>"74", "nom"=>"Creuse", "article"=>"La", "cheflieu"=>"Guéret", "habitant"=>"Creusois");
        $depFr["79"] = array("regionId"=>"54", "nom"=>"Deux-Sèvres", "article"=>"Les", "cheflieu"=>"Niort", "habitant"=>"Deux-Sévrien");
        $depFr["24"] = array("regionId"=>"72", "nom"=>"Dordogne", "article"=>"La", "cheflieu"=>"Périgueux", "habitant"=>"Dordognais");
        $depFr["25"] = array("regionId"=>"43", "nom"=>"Doubs", "article"=>"Le", "cheflieu"=>"Besançon", "habitant"=>"Doubien");
        $depFr["26"] = array("regionId"=>"82", "nom"=>"Drôme", "article"=>"La", "cheflieu"=>"Valence", "habitant"=>"Drômois");
        $depFr["91"] = array("regionId"=>"11", "nom"=>"Essonne", "article"=>"L'", "cheflieu"=>"Évry", "habitant"=>"Essonnien");
        $depFr["27"] = array("regionId"=>"23", "nom"=>"Eure", "article"=>"L'", "cheflieu"=>"Évreux", "habitant"=>"Eurois");
        $depFr["28"] = array("regionId"=>"24", "nom"=>"Eure-et-Loir", "article"=>"L'", "cheflieu"=>"Chartres", "habitant"=>"Eurélien");
        $depFr["29"] = array("regionId"=>"53", "nom"=>"Finistère", "article"=>"Le", "cheflieu"=>"Quimper", "habitant"=>"Finistérien");
        $depFr["30"] = array("regionId"=>"91", "nom"=>"Gard", "article"=>"Le", "cheflieu"=>"Nîmes", "habitant"=>"Gardois");
        $depFr["32"] = array("regionId"=>"73", "nom"=>"Gers", "article"=>"Le", "cheflieu"=>"Auch", "habitant"=>"Gersois");
        $depFr["33"] = array("regionId"=>"72", "nom"=>"Gironde", "article"=>"La", "cheflieu"=>"Bordeaux", "habitant"=>"Girondin");
        $depFr["971"] = array("regionId"=>"1", "nom"=>"Guadeloupe", "article"=>"La", "cheflieu"=>"Basse-Terre", "habitant"=>"Guadeloupéen");
        $depFr["973"] = array("regionId"=>"3", "nom"=>"Guyane", "article"=>"La", "cheflieu"=>"Cayenne", "habitant"=>"Guyanais");
        $depFr["05"] = array("regionId"=>"93", "nom"=>"Hautes-Alpes", "article"=>"Les", "cheflieu"=>"Gap", "habitant"=>"Haut-Alpin");
        $depFr["65"] = array("regionId"=>"73", "nom"=>"Hautes-Pyrénées", "article"=>"Les", "cheflieu"=>"Tarbes", "habitant"=>"Haut-Pyrénéen");
        $depFr["2B"] = array("regionId"=>"94", "nom"=>"Haute-Corse", "article"=>"La", "cheflieu"=>"Bastia", "habitant"=>"Corse");
        $depFr["31"] = array("regionId"=>"73", "nom"=>"Haute-Garonne", "article"=>"La", "cheflieu"=>"Toulouse", "habitant"=>"Haut-Garonnais");
        $depFr["43"] = array("regionId"=>"83", "nom"=>"Haute-Loire", "article"=>"La", "cheflieu"=>"Le Puy-en-Velay", "habitant"=>"Altiligérien");
        $depFr["52"] = array("regionId"=>"21", "nom"=>"Haute-Marne", "article"=>"La", "cheflieu"=>"Chaumont", "habitant"=>"Haut-Marnais");
        $depFr["70"] = array("regionId"=>"43", "nom"=>"Haute-Saône", "article"=>"La", "cheflieu"=>"Vesoul", "habitant"=>"Haut-Saônois");
        $depFr["74"] = array("regionId"=>"82", "nom"=>"Haute-Savoie", "article"=>"La", "cheflieu"=>"Annecy", "habitant"=>"Haut-Savoyard");
        $depFr["87"] = array("regionId"=>"74", "nom"=>"Haute-Vienne", "article"=>"La", "cheflieu"=>"Limoges", "habitant"=>"Haut-Viennois");
        $depFr["92"] = array("regionId"=>"11", "nom"=>"Hauts-de-Seine", "article"=>"Les", "cheflieu"=>"Nanterre", "habitant"=>"Altoséquanais");
        $depFr["68"] = array("regionId"=>"42", "nom"=>"Haut-Rhin", "article"=>"Le", "cheflieu"=>"Colmar", "habitant"=>"Haut-Rhinois");
        $depFr["34"] = array("regionId"=>"91", "nom"=>"Hérault", "article"=>"L'", "cheflieu"=>"Montpellier", "habitant"=>"Héraultais");
        $depFr["35"] = array("regionId"=>"53", "nom"=>"Ille-et-Vilaine", "article"=>"L'", "cheflieu"=>"Rennes", "habitant"=>"Brétillien");
        $depFr["36"] = array("regionId"=>"24", "nom"=>"Indre", "article"=>"L'", "cheflieu"=>"Châteauroux", "habitant"=>"Indrien");
        $depFr["37"] = array("regionId"=>"24", "nom"=>"Indre-et-Loire", "article"=>"L'", "cheflieu"=>"Tours", "habitant"=>"Tourangeau");
        $depFr["38"] = array("regionId"=>"82", "nom"=>"Isère", "article"=>"L'", "cheflieu"=>"Grenoble", "habitant"=>"Isérois, Iseran");
        $depFr["39"] = array("regionId"=>"43", "nom"=>"Jura", "article"=>"Le", "cheflieu"=>"Lons-le-Saunier", "habitant"=>"Jurassien");
        $depFr["40"] = array("regionId"=>"72", "nom"=>"Landes", "article"=>"Les", "cheflieu"=>"Mont-de-Marsan", "habitant"=>"Landais");
        $depFr["974"] = array("regionId"=>"4", "nom"=>"La Réunion", "article"=>"La", "cheflieu"=>"Saint-Denis", "habitant"=>"Réunionais");
        $depFr["42"] = array("regionId"=>"82", "nom"=>"Loire", "article"=>"La", "cheflieu"=>"Saint-Étienne", "habitant"=>"Ligérien");
        $depFr["45"] = array("regionId"=>"24", "nom"=>"Loiret", "article"=>"Le", "cheflieu"=>"Orléans", "habitant"=>"Loirétain");
        $depFr["44"] = array("regionId"=>"52", "nom"=>"Loire-Atlantique", "article"=>"La", "cheflieu"=>"Nantes", "habitant"=>"Mariligérien");
        $depFr["41"] = array("regionId"=>"24", "nom"=>"Loir-et-Cher", "article"=>"Le", "cheflieu"=>"Blois", "habitant"=>"Loir-et-Chérien");
        $depFr["46"] = array("regionId"=>"73", "nom"=>"Lot", "article"=>"Le", "cheflieu"=>"Cahors", "habitant"=>"Lotois");
        $depFr["47"] = array("regionId"=>"72", "nom"=>"Lot-et-Garonne", "article"=>"Le", "cheflieu"=>"Agen", "habitant"=>"Lot-et-Garonnais");
        $depFr["48"] = array("regionId"=>"91", "nom"=>"Lozère", "article"=>"La", "cheflieu"=>"Mende", "habitant"=>"Lozèrien");
        $depFr["49"] = array("regionId"=>"52", "nom"=>"Maine-et-Loire", "article"=>"Le", "cheflieu"=>"Angers", "habitant"=>"Mainoligérien");
        $depFr["50"] = array("regionId"=>"25", "nom"=>"Manche", "article"=>"La", "cheflieu"=>"Saint-Lô", "habitant"=>"Manchois");
        $depFr["51"] = array("regionId"=>"21", "nom"=>"Marne", "article"=>"La", "cheflieu"=>"Châlons-en-Champagne", "habitant"=>"Marnais");
        $depFr["972"] = array("regionId"=>"2", "nom"=>"Martinique", "article"=>"La", "cheflieu"=>"Fort-de-France", "habitant"=>"Martiniquais");
        $depFr["53"] = array("regionId"=>"52", "nom"=>"Mayenne", "article"=>"La", "cheflieu"=>"Laval", "habitant"=>"Mayennais");
        $depFr["976"] = array("regionId"=>"6", "nom"=>"Mayotte", "article"=>"", "cheflieu"=>"Dzaoudzi", "habitant"=>"Mahorais");
        $depFr["54"] = array("regionId"=>"41", "nom"=>"Meurthe-et-Moselle", "article"=>"La", "cheflieu"=>"Nancy", "habitant"=>"Meurthe-et-Mosellan");
        $depFr["55"] = array("regionId"=>"41", "nom"=>"Meuse", "article"=>"La", "cheflieu"=>"Bar-le-Duc", "habitant"=>"Meusien");
        $depFr["56"] = array("regionId"=>"53", "nom"=>"Morbihan", "article"=>"Le", "cheflieu"=>"Vannes", "habitant"=>"Morbihannais");
        $depFr["57"] = array("regionId"=>"41", "nom"=>"Moselle", "article"=>"La", "cheflieu"=>"Metz", "habitant"=>"Mosellan");
        $depFr["58"] = array("regionId"=>"26", "nom"=>"Nièvre", "article"=>"La", "cheflieu"=>"Nevers", "habitant"=>"Nivernais");
        $depFr["59"] = array("regionId"=>"31", "nom"=>"Nord", "article"=>"Le", "cheflieu"=>"Lille", "habitant"=>"Nordiste");
        $depFr["60"] = array("regionId"=>"22", "nom"=>"Oise", "article"=>"L'", "cheflieu"=>"Beauvais", "habitant"=>"Isarien");
        $depFr["61"] = array("regionId"=>"25", "nom"=>"Orne", "article"=>"L'", "cheflieu"=>"Alençon", "habitant"=>"Ornais");
        $depFr["75"] = array("regionId"=>"11", "nom"=>"Paris", "article"=>"", "cheflieu"=>"Paris", "habitant"=>"Parisien");
        $depFr["62"] = array("regionId"=>"31", "nom"=>"Pas-de-Calais", "article"=>"Le", "cheflieu"=>"Arras", "habitant"=>"Pas-de-Calaisien");
        $depFr["63"] = array("regionId"=>"83", "nom"=>"Puy-de-Dôme", "article"=>"Le", "cheflieu"=>"Clermont-Ferrand", "habitant"=>"Puydomois");
        $depFr["64"] = array("regionId"=>"72", "nom"=>"Pyrénées-Atlantiques", "article"=>"Les", "cheflieu"=>"Pau", "habitant"=>"Béarnais");
        $depFr["66"] = array("regionId"=>"91", "nom"=>"Pyrénées-Orientales", "article"=>"Les", "cheflieu"=>"Perpignan", "habitant"=>"Pyrénaliens");
        $depFr["69"] = array("regionId"=>"82", "nom"=>"Rhône", "article"=>"Le", "cheflieu"=>"Lyon", "habitant"=>"Rhodanien");
        $depFr["71"] = array("regionId"=>"26", "nom"=>"Saône-et-Loire", "article"=>"La", "cheflieu"=>"Mâcon", "habitant"=>"Saône-et-Loirien");
        $depFr["72"] = array("regionId"=>"52", "nom"=>"Sarthe", "article"=>"La", "cheflieu"=>"Le Mans", "habitant"=>"Sarthois");
        $depFr["73"] = array("regionId"=>"82", "nom"=>"Savoie", "article"=>"La", "cheflieu"=>"Chambéry", "habitant"=>"Savoyard");
        $depFr["77"] = array("regionId"=>"11", "nom"=>"Seine-et-Marne", "article"=>"La", "cheflieu"=>"Melun", "habitant"=>"Seine-et-Marnais");
        $depFr["76"] = array("regionId"=>"23", "nom"=>"Seine-Maritime", "article"=>"La", "cheflieu"=>"Rouen", "habitant"=>"Seinomarin");
        $depFr["93"] = array("regionId"=>"11", "nom"=>"Seine-Saint-Denis", "article"=>"La", "cheflieu"=>"Bobigny", "habitant"=>"Séquano-Dyonisien");
        $depFr["80"] = array("regionId"=>"22", "nom"=>"Somme", "article"=>"La", "cheflieu"=>"Amiens", "habitant"=>"Samarien");
        $depFr["81"] = array("regionId"=>"73", "nom"=>"Tarn", "article"=>"Le", "cheflieu"=>"Albi", "habitant"=>"Tarnais");
        $depFr["82"] = array("regionId"=>"73", "nom"=>"Tarn-et-Garonne", "article"=>"Le", "cheflieu"=>"Montauban", "habitant"=>"Tarn-et-Garonnais");
        $depFr["90"] = array("regionId"=>"43", "nom"=>"Territoire de Belfort", "article"=>"Le", "cheflieu"=>"Belfort", "habitant"=>"Belfortain");
        $depFr["94"] = array("regionId"=>"11", "nom"=>"Val-de-Marne", "article"=>"Le", "cheflieu"=>"Créteil", "habitant"=>"Valdemarnais");
        $depFr["95"] = array("regionId"=>"11", "nom"=>"Val-d'Oise", "article"=>"Le", "cheflieu"=>"Pontoise", "habitant"=>"Valdoisien");
        $depFr["83"] = array("regionId"=>"93", "nom"=>"Var", "article"=>"Le", "cheflieu"=>"Toulon", "habitant"=>"Varois");
        $depFr["84"] = array("regionId"=>"93", "nom"=>"Vaucluse", "article"=>"Le", "cheflieu"=>"Avignon", "habitant"=>"Vauclusien");
        $depFr["85"] = array("regionId"=>"52", "nom"=>"Vendée", "article"=>"La", "cheflieu"=>"La Roche-sur-Yon", "habitant"=>"Vendéen");
        $depFr["86"] = array("regionId"=>"54", "nom"=>"Vienne", "article"=>"La", "cheflieu"=>"Poitiers", "habitant"=>"Viennois");
        $depFr["88"] = array("regionId"=>"41", "nom"=>"Vosges", "article"=>"Les", "cheflieu"=>"Épinal", "habitant"=>"Vosgien");
        $depFr["89"] = array("regionId"=>"26", "nom"=>"Yonne", "article"=>"L'", "cheflieu"=>"Auxerre", "habitant"=>"Icaunais");
        $depFr["78"] = array("regionId"=>"11", "nom"=>"Yvelines", "article"=>"Les", "cheflieu"=>"Versailles", "habitant"=>"Yvelinois");

        $departments = array();
        foreach ($depFr as $key => $value){
            $departments[$value['nom']] = $key;
        }

        return $departments;
    }
}