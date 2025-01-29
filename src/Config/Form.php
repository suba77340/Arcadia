<?php

namespace App\Config;

class Form
{
    private $formCode = '';

    // genere formulaire html
    public function create()
    {
        return $this->formCode;
    }
    // valide si ts les champs sont remplis; en static pour interroger sans instancier
    public static function validate(array $form, array $champs)
    {
        //parcourt les champs
        foreach ($champs as $champ) {
            // si champ absent / vide dans formulaire
            if (!isset($form[$champ]) || empty($form[$champ])) {
                // on sort en retournant false
                return false;
            }
        }
        return true;
    }
    private function ajoutAttributs(array $attributs): string
    {
        //on initialise chaine caracteres
        $str = '';

        //liste attributs court
        $courts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate'];

        foreach ($attributs as $attribut => $valeur) {

            if (in_array($attribut, $courts) && $valeur == true) {
                $str .= " $attribut";
            } else {
                // ajoute attribut='valeur'
                $str .= " $attribut=\"$valeur\"";
            }
        }
        return $str;
    }

    public function debutForm(string $methode = 'POST', string $action = '#', array $attributs = []): self
    {   //creer balise form
        $this->formCode .= "<form action='$action' method='$methode'";
        //ajoute les attributs eventuels
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) . '>' : '>';
        return $this;
    }
    // balise fin form
    public function finForm(): self
    {
        $this->formCode .= "</form>";
        return $this;
    }

    public function ajoutLabelFor(string $for, string $texte, array $attributs = []): self
    {   // ouvre balise
        $this->formCode .= "<label for= '$for'";
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';
        $this->formCode .= ">$texte</label>";
        return $this;
    }

    public function ajoutInput(string $type, string $nom, array $attributs = []): self
    {
        $this->formCode .= "<input type='$type' name='$nom'";
        $this->formCode .=$attributs ? $this->ajoutAttributs($attributs). '>' :'>' ;

        return $this;
    }

    public function ajoutTextArea(string $nom, string $valeur = '',array $attributs = []): self
    {
        $this->formCode .= "<textarea name= '$nom'";
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';
        $this->formCode .= ">$valeur</textarea>";
        return $this;
    }

    public function ajoutSelect(string $nom, array $options,array $attributs = []): self
    { // on cree le select
        $this->formCode .= "<select name= '$nom'";
        // ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs). '>' :'>' ;
        foreach($options as $valeur => $texte){
            $this->formCode .= "<option value=\"$valeur\">$texte</option>";
        }
        // ferme le select
        $this->formCode .= '</select>';
        return $this;
}

    public function ajoutBouton(string $texte, array $attributs = []): self
    {   
        $this->formCode .= "<button";
        //ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs): '';
        //ajoute le texte et on ferme bouton
        $this->formCode .= ">$texte</button";
        return $this;
    }
}