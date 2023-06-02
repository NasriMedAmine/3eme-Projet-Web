/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;
import entitie.Team;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import utils.Statics;

/**
 *
 * @author farouk
 */
public class TeamServices {
    public static TeamServices instance = null;
    
    private ConnectionRequest req;
    
    public static TeamServices getInstance(){
    if(instance == null)
        instance = new TeamServices();
    return instance;
    }
    
    public TeamServices(){
       req = new ConnectionRequest();
    }
    
    public void addTeam(Team team){
       String url=Statics.BASE_URL+"/AddteamJson?teamName="+team.getTeam_Name()+"&nbPlayers="+team.getNb_Players()+"&players="+team.getPlayers()+"&favoriteGames="
               +team.getFavorite_Games()+"&teamDesciption="+team.getTeam_Desciption()+"&password="+team.getPassword()+"&teamMail="+team.getTeam_Mail()+"&logo="+team.getLogo();
       
       req.setUrl(url);
       req.addResponseListener((e)->{
           String str =new String(req.getResponseData());
           System.out.println("data == "+str);
       });
        NetworkManager.getInstance().addToQueueAndWait(req);
       
    }
    
    public ArrayList <Team> ShowTeam(){
       ArrayList<Team > result = new ArrayList<>();
       String url=Statics.BASE_URL+"/showjson";
       
       req.setUrl(url);
       req.addResponseListener(new ActionListener<NetworkEvent>(){
        @Override
        public void actionPerformed(NetworkEvent evt){
            JSONParser jsonp;
        jsonp= new JSONParser();
            try {
                Map<String,Object>mapTeams=jsonp.parseJSON(new CharArrayReader(new String(req.getResponseData()).toCharArray()));
                List<Map<String,Object>>listOfmaps=(List<Map<String,Object>>)mapTeams.get("root");
                for(Map<String,Object> obj : listOfmaps){
                     Team t = new Team();
                     float id=Float.parseFloat(obj.get("Id_Team").toString());
                    
                     String name =obj.get("Team_Name").toString();
                     float nbplayers=Float.parseFloat(obj.get("Nb_Players").toString());
                     String players =obj.get("Players").toString();
                     String favorite_Games =obj.get("Favorite_Games").toString();
                     String team_Desciption =obj.get("Team_Desciption").toString();
                     String password =obj.get("Password").toString();
                     String team_Mail =obj.get("Team_Mail").toString();

                     String logo =obj.get("logo").toString();
                     
                     t.setId_Team((int) id);
                     t.setFavorite_Games(favorite_Games);
                     t.setLogo(logo);
                     t.setNb_Player((int) nbplayers);
                     t.setPassword(password);
                     t.setPlayers(players);
                     t.setTeam_Desciption(team_Desciption);
                     t.setTeam_Mail(team_Mail);
                     t.setTeam_Name(team_Mail);
                     
                       result.add(t);
                }
            } catch (Exception e) {
                e.printStackTrace();
            }
                
                }
       }
               );
               NetworkManager.getInstance().addToQueueAndWait(req);
              return result ;
    }
    
    public Team teamProfile(int Id_Team ,Team team){
              String url=Statics.BASE_URL+"/teamprofilejson?"+Id_Team;
                    req.setUrl(url);
                  String str = new String (req.getResponseData());
                         req.addResponseListener(((evt)->{
                             JSONParser jsonp =new JSONParser();
                             try {
                            Map<String,Object>obj=jsonp.parseJSON(new CharArrayReader(new String(str).toCharArray()));
                            team.setFavorite_Games(obj.get("Favorite_Games").toString());
                             team.setLogo(obj.get("logo").toString());
                              team.setPassword(obj.get("Password").toString());
                               team.setPlayers(obj.get("Players").toString());
                                team.setTeam_Desciption(obj.get("Team_Desciption").toString());
                                 team.setTeam_Mail(obj.get("Team_Mail").toString());
                                  team.setTeam_Name(obj.get("Team_Name").toString());
                                    team.setNb_Player(Integer.parseInt(obj.get("Nb_Players").toString()));


                                 

        } catch (Exception e) {
                                 System.out.println("error related to "+e.getMessage());
        }
                             System.out.println("data =="+str);
                         }));

                                 NetworkManager.getInstance().addToQueueAndWait(req);
                                  return team;
    }
    
    
    
    
}
