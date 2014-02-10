<html>
<meta charset="utf-8">
<body>
</body>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.4.1/d3.min.js"></script>
<script src="js/d3.layout.cloud.js"></script>
<script>
  var fill = d3.scale.category20();

  function cloud(data)
  {
    d3.layout.cloud().size([1000, 1000])
        .words(data.map(function(d) {
          return {text: d.tag, size: 10 + d.size * 120};
        }))
        .padding(5)
        .rotate(function() { return ~~(Math.random() * 2) * 90; })
        .font("Impact")
        .fontSize(function(d) { return d.size; })
        .on("end", draw)
        .start();
  }

  function draw(words) {
    d3.select("body").append("svg")
        .attr("width", 1000)
        .attr("height", 1000)
      .append("g")
        .attr("transform", "translate(500,500)")
      .selectAll("text")
        .data(words)
      .enter().append("text")
        .style("font-size", function(d) { return d.size + "px"; })
        .style("font-family", "Impact")
        .style("fill", function(d, i) { return fill(i); })
        .attr("text-anchor", "middle")
        .attr("transform", function(d) {
          return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
        })
        .text(function(d) { return d.text; });
  }

  $.getJSON('api/<?=$twitterId;?>').done(function(data){
    cloud(data);
  });
</script>
</html>