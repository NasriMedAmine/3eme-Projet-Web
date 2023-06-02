/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import com.codename1.components.InfiniteProgress;
import com.codename1.ui.Button;
import com.codename1.ui.Component;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.util.Resources;
import entitie.Team;
import services.TeamServices;

/**
 *
 * @author farouk
 */
public class AddTeamForm extends BaseForm{
    Form current ;
    public AddTeamForm(Resources res){
    super("Create Team",BoxLayout.y());
    Toolbar tp =new Toolbar(true);
    current =this;
        setToolbar(tp);
        getTitleArea().setUIID("container");
        setTitle("Create Team");
        getContentPane().setScrollVisible(false);
        
        TextField Team_Name =new TextField("","enter Team_Name !" );
        Team_Name.setUIID("TextFieldBlack");
        addStringValue("Team_Name",Team_Name);
        
         TextField Nb_Players =new TextField("","enter Nb_Players !" );
        Nb_Players.setUIID("TextFieldBlack");
        addStringValue("Nb_Players",Nb_Players);
        
         TextField Players =new TextField("","enter Players !" );
        Players.setUIID("TextFieldBlack");
        addStringValue("Players",Players);
        
         TextField Favorite_Games =new TextField("","enter Favorite_Games !" );
        Favorite_Games.setUIID("TextFieldBlack");
        addStringValue("Favorite_Games",Favorite_Games);
        
         TextField Team_Desciption =new TextField("","enter Team_Desciption !" );
        Team_Desciption.setUIID("TextFieldBlack");
        addStringValue("Team_Desciption",Team_Desciption);
        
         TextField Password =new TextField("","enter Password !" );
        Password.setUIID("TextFieldBlack");
        addStringValue("Password",Password);
        
         TextField Team_Mail =new TextField("","enter Team_Mail !" );
        Team_Mail.setUIID("TextFieldBlack");
        addStringValue("Team_Mail",Team_Mail);
        
         TextField logo =new TextField("","enter logo !" );
        logo.setUIID("TextFieldBlack");
        addStringValue("logo",logo);
        
        Button bntadd =new Button("create");
        addStringValue("", bntadd);
        bntadd.addActionListener((e)->{
             try {
                if (Team_Name.getText()=="" || Password.getText()=="" || Nb_Players.getText() ==""){
                      Dialog.show("Veuillez verifier les donnees","","Annuler","OK");
                }
                else{
                    InfiniteProgress ip = new InfiniteProgress();
                    final Dialog iDialog = ip.showInfiniteBlocking();
                    Team t=new Team(String.valueOf(Team_Name.getText()).toString(),Integer.parseInt(Nb_Players.getText()),String.valueOf(Players.getText()).toString()
                    ,String.valueOf(Favorite_Games.getText()).toString(),String.valueOf(Team_Desciption.getText()).toString(),String.valueOf(Password.getText()).toString(),
                    String.valueOf(Team_Mail.getText()).toString(),String.valueOf(Team_Name.getText()).toString());
                    System.out.println("data =="+t);
                    TeamServices.getInstance().addTeam(t);
                    iDialog.dispose();
                    refreshTheme();
                }
                    
            } catch (Exception ex) {
                ex.printStackTrace();
            }
        });
    
    }

    private void addStringValue(String s, Component v) {
        add(BorderLayout.west(new Label (s,"PaddedLabel")).add(BorderLayout.CENTER,v));
        add(createLineSeparator(0xeeeeee));
    }
}
