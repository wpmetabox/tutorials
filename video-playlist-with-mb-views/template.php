<div class="playlist-container">
  <div class="playlist-content">
    <p class="playlist-title">Playlist</p>
    <div id="video-playlist"> 
        {% for clone in post.video %}
          <div class="video">
              <img src="https://img.youtube.com/vi/{{ clone.id }}/mqdefault.jpg"/>
              <div movieurl="https://www.youtube.com/embed/{{ clone.id }}" class="video-name" >{{ clone.title }}</div>
          </div> 
        {% endfor %}
    </div>
  </div>
 
  <div class="playlist-iframe">
          <iframe  id="videoarea" src="https://www.youtube.com/embed/{{post.video[0].id}}" 
          title="YouTube video player" frameborder="0" 
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
          allowfullscreen></iframe>
  </div>
</div>
