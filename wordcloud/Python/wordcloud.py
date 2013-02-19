from collections import Counter, defaultdict
import string
#
#
# @author Harish Prasanna http://www.facebook.com/harishperfect
#
def writeCloud(taglist, ranges, outputfile):
  outputf = open(outputfile, 'w')
  outputf.write("<html><head><title> Word Cloud by N.D.P.Harish Prasanna </title>");
  outputf.write("<style type=\"text/css\">\n")
  outputf.write(".xxsTag {font-size: 30px;}\n")
  outputf.write(".sTag {font-size: 50px;}\n")
  outputf.write(".mTag {font-size: 90px;}\n")
  outputf.write(".lTag {font-size: 150px;}\n")
  outputf.write(".xxlTag {font-size: 200px;}\n")
  outputf.write("</style>\n")
  outputf.write("</head><body>");
  outputf.write(" <p><b>Total No of Lines:</b>"+ str(lcount)+  "</p>")
  outputf.write(" <p><b>Total No of Words:</b>"+ str(wcount)+  "</p>")
  outputf.write(" <p><b>The Unique Words are:</b>"+ uniquewrds +  "</p>")
  outputf.write(" <p><b>Total No of Tagged Words:</b>"+ str(tagcount) +  "</p>")
  outputf.write(" <p><b>Word Cloud:</b></p>")
  rangeStyle = ["xxsTag", "sTag", "mTag", "lTag", "xxlTag"]
  taglist.sort(lambda x, y: cmp(x[0], y[0]))
  for tag in taglist:
    rangeIndex = 0
    for range in ranges:
      url = "http://127.0.0.1:8080/prog/lines.php?name=" + tag[0]
      if (tag[1] >= range[0] and tag[1] <= range[1]):
        outputf.write("<span class=\"" + rangeStyle[rangeIndex] + "\"><a href=\"" + url + "\"title=\""+ str(range[0]) +"\">" + tag[0] + "</a></span> ")
        break
      rangeIndex = rangeIndex + 1
  outputf.write("</body></html>");
  outputf.close();

def getRanges(taglist):
  maxcount = taglist[0][1]
  mincount = taglist[len(taglist) - 1][1]
  distrib = (maxcount - mincount) / 4;
  index = mincount
  ranges = []
  while (index <= maxcount):
    range = (index, index )
    index = index + distrib
    ranges.append(range)
  return ranges

inputtest=open('test.txt','r')
inputnoise=open('noise.txt','r')
lcount= sum(1 for line in open('test.txt'))
noisel=inputnoise.read()[:-1]
noisew=noisel.translate(None, string.punctuation)
nwords=noisew.lower().split()
lines=inputtest.read()[:-1]
wordsstripped=lines.translate(None, string.punctuation)
words=wordsstripped.lower().split()
wcount=len(words)
unwords= [b for b in words if b not in nwords]
uniquewrds=' '.join(unwords)
uwords=Counter()
uwords.update(unwords)
taglit=uwords.most_common()
tagcount=taglit
tagcount=len(tagcount)
if(taglit != ""):
  ranges=getRanges(taglit)
writeCloud(taglit,ranges,'index.html')
