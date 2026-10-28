/* ============================================================
   Cypher-One AI Readiness Assessment — v1
   Design system inherited from Cypher-One Smart Governance.
   ============================================================ */

var VERSION = "Version 1", ALIGNED = "August 2026";
var TITLE = "Cypher-One AI Readiness Assessment";
var TAGLINE = "Ambition is not the constraint. Execution is.";

/* WordPress bridge (Cypher-One theme): settings and endpoint come from window.C1A. */
var C1A = window.C1A || {};
if (C1A.title) TITLE = C1A.title;
if (C1A.tagline) TAGLINE = C1A.tagline;
if (C1A.version) VERSION = C1A.version;
if (C1A.aligned) ALIGNED = C1A.aligned;
function c1aEmail(){ return esc(C1A.email || "contact@cypher-one.ai"); }
function c1aWeb(){ return esc(C1A.web || "www.cypher-one.ai"); }
function c1aLoc(){ return esc(C1A.location || "Doha, Qatar"); }

var BANDS = [
  { min:0,  max:40,  label:"Exploring",     ar:"استكشاف",  color:"#E8321A" },
  { min:41, max:60,  label:"Experimenting", ar:"تجريب",    color:"#C8892A" },
  { min:61, max:80,  label:"Scaling",       ar:"توسّع",    color:"#2E7D8A" },
  { min:81, max:100, label:"Leading",       ar:"ريادي",    color:"#2C6E5B" }
];
function band(v){ for (var i=0;i<BANDS.length;i++){ if(v>=BANDS[i].min && v<=BANDS[i].max) return BANDS[i]; } return BANDS[0]; }

var DIMS = [
  { key:"strategy",   label:"Strategy",   desc:"A written AI plan tied to business goals, and someone who owns it." },
  { key:"leadership", label:"Leadership", desc:"Whether your board understands AI, and whether AI is properly funded." },
  { key:"people",     label:"People",     desc:"Training matched to the role, and access to the skills you need." },
  { key:"data",       label:"Data",       desc:"Whether AI can reach your data, and whether that data can be trusted." },
  { key:"technology", label:"Technology", desc:"A shared platform, and AI connected to the systems people use daily." },
  { key:"process",    label:"Process",    desc:"Redesigning the work around AI, and managing the change with staff." },
  { key:"value",      label:"Value",      desc:"Choosing use cases by value, and measuring what AI actually returns." },
  { key:"trust",      label:"Trust",      desc:"Basic rules for AI use, and knowing every AI tool in the organisation." }
];

var PILLARS = [
  { n:1, name:"Capability Building",           dims:["people","leadership"],   colour:"#B31B0C",
    cta:"A tiered AI literacy programme, plus a Board-Level AI Briefing." },
  { n:2, name:"Governance & Value Assurance",  dims:["trust","value"],         colour:"#C8892A",
    cta:"The ISO 42001 AIMS Readiness Sprint — gap assessment and remediation roadmap." },
  { n:3, name:"Transformation & Strategy",     dims:["strategy","process"],    colour:"#2E7D8A",
    cta:"An AI maturity assessment with use-case prioritisation and workflow redesign." },
  { n:4, name:"Platforms & Solutions",         dims:["data","technology"],     colour:"#2C6E5B",
    cta:"Solution scoping and architecture, vendor selection and AI vendor due diligence." }
];

/* ---------- Page 1 content ---------- */
var SIX = [
  ["Strategy & Ownership","Most AI spend fails not on technology but on ownership — no named sponsor, no budget, no plan tied to business goals. Region-wide, 70% of CEOs have an AI roadmap. Far fewer have someone accountable for delivering it."],
  ["People & Skills","AI creates value only when people change how they work. That needs training matched to the role — a frontline user, an analyst and a board member each need something different."],
  ["Data Foundations","The Gulf's hardest constraint. Only 16% of GCC CEOs say their most-used AI tools can reach all the data they need. Silos and legacy systems stop good models cold."],
  ["Technology & Platforms","Every project starting from scratch means duplicate cost and nothing that compounds. A shared platform is what turns an AI pilot into an asset."],
  ["Workflow & Adoption","Automating one step while keeping every approval around it delivers no benefit. The work has to be redesigned, not decorated."],
  ["Value & Measurement","Unmeasured AI is unfunded AI. Without a baseline and a business case, the programme cannot survive its first budget review."]
];

var CASES = [
  { t:"US$62 million, and never used",
    s:"A leading cancer hospital in the United States worked with IBM to build an AI tool to help doctors choose treatments. It paid more than US$62 million to outside firms and ended up with no working product. The system was never used with patients and was never tested at any other hospital. The reason was straightforward: the AI could not connect to the hospital's main patient record system, so doctors were left working from outdated information.",
    c:"US$62 million over four years, with nothing usable at the end. The investment went entirely into the AI, while the data it depended on was never sorted out first." },
  { t:"The price it kept getting wrong",
    s:"A large property website in the United States used AI to decide what to pay for people's homes, and bought thousands of them. The AI consistently valued them too highly, so the homes were worth less than the company had paid. The business was closed in November 2021, with the chief executive saying that predicting house prices proved far harder than the company had expected.",
    c:"US$881 million and a quarter of the workforce — around 2,000 jobs. The AI repeated the same mistake thousands of times before anyone intervened." },
  { t:"The order it could not hear",
    s:"A global fast-food company tested AI to take orders at the drive-through. The AI pilot ran in more than 100 restaurants for around two years. Staff reported that it got the order right only about 80% of the time, and that it was expensive to operate. The system frequently misheard customers and added items nobody had ordered. Recordings of these mistakes spread widely online.",
    c:"Three years of work across more than 100 restaurants, switched off in June 2024. The total spend was never made public. The technology performed well in testing, but not in a noisy drive-through with real customers." },
  { t:"Too far, too fast",
    s:"A European finance company replaced much of its customer service with AI, and announced that the system was doing the work of 700 people. It expected the change to add around US$40 million to profit in a single year. In May 2025 the chief executive reversed the decision and began recruiting people again, explaining that while the AI was cheaper, the quality of service it delivered was lower, and that customers should always be able to reach a real person.",
    c:"A US$40 million saving that had to be given back, plus the cost of rebuilding the team, which was never published. Reducing headcount is quick. Rebuilding is slow and expensive." }
];
var CASE_C = [
  { b:"#B4432E", bg:"#FBEFEC", t:"#7A2E20" },
  { b:"#C8892A", bg:"#FBF3E5", t:"#7A5314" },
  { b:"#2E7D8A", bg:"#E6F2F4", t:"#1E5A64" },
  { b:"#6B4E8A", bg:"#F1ECF7", t:"#493460" }
];

var ANCHORS = [
  ["QNV 2030","#1F1D1C","Qatar National Vision 2030 sets human, social, economic and environmental development as the national goal. AI adoption is judged against whether it serves those aims.","The national frame for every organisation in Qatar."],
  ["MCIT National AI Policy","#B31B0C","Qatar's national AI direction, setting the principles and pillars organisations are expected to align to.","Applies to everyone operating in Qatar."],
  ["Digital Agenda 2030","#2E7D8A","Qatar's digital transformation programme, including supervised routes for testing higher-risk AI before it goes to market.","Relevant if you are building something new."],
  ["GCC AI Playbook 2026","#C8892A","Regional best practice on building AI capability: assess risk and capability first, then build literacy by tier and function.","Applies across the Gulf."],
  ["ISO/IEC 42001","#2C6E5B","The international standard for managing AI. The pivot point that bridges Qatar, Gulf and EU expectations in one system.","The standard your partners will ask about."]
];

/* ---------- Profile fields (identical to Smart Governance) ---------- */
var SECTORS = ["Healthcare & Medical","Financial Services","Government & Public Sector","HR & Recruitment","Legal Services","Education","Security & Law Enforcement","Transportation & Logistics","Energy & Utilities","Manufacturing & Industrial","Real Estate & Construction","Hospitality & Tourism","Telecommunications","Media / Technology","Retail & E-commerce","Other"];
var COUNTRIES = ["Qatar","Saudi Arabia","United Arab Emirates","Kuwait","Bahrain","Oman","Other"];
var SIZES = ["1–50","51–250","251–1,000","1,001–5,000","More than 5,000"];
var ROLES = ["Board / C-suite","Risk & Compliance","Legal","IT / Data","Other"];
var USAGE = ["Yes, we're actively using AI","Planning to implement soon","No current AI usage"];
var AITYPES = ["Chatbots / Virtual Assistants","Content creation (text, images, video)","Generative AI / Large Language Models","Recommendation Systems","Predictive Analytics","Computer Vision / Image Recognition","Natural Language Processing","Translation","Coding Assistants","Automated Decision Making","Fraud Detection","HR / Recruitment Tools","Robotic Process Automation (RPA)","Search & Knowledge Tools","Other"];
var RISKCLASS = [["High-Risk AI","Affects safety, rights or critical services (e.g. hiring, credit scoring, medical diagnosis)."],["Limited-Risk AI","Customer interaction, chatbots — needs transparency."],["Minimal-Risk AI","Spam filters, recommendation engines — few obligations."],["Not sure","We're not sure which category we fall into."]];
var RISKPROC = ["Yes","We're currently building one","No","Not sure"];

var SECTOR_GROUP = {"Healthcare & Medical":"Healthcare","Financial Services":"Financial services","Government & Public Sector":"Government & public","HR & Recruitment":"Government & public","Legal Services":"Government & public","Education":"Government & public","Security & Law Enforcement":"Government & public","Transportation & Logistics":"Energy & industrial","Energy & Utilities":"Energy & industrial","Manufacturing & Industrial":"Energy & industrial","Real Estate & Construction":"Energy & industrial","Hospitality & Tourism":"SME / Enterprise","Telecommunications":"Media & technology","Media / Technology":"Media & technology","Retail & E-commerce":"SME / Enterprise","Other":"Other"};

/* Readiness weights — Data/Technology up for energy & industrial, People/Leadership up for
   government & public, Value up for SME/Enterprise, Trust up for financial services. */
var WEIGHTS = {
  "Financial services":  { strategy:1.3, leadership:1.3, people:1.2, data:1.4, technology:1.3, process:1.2, value:1.3, trust:1.8 },
  "Government & public": { strategy:1.3, leadership:1.7, people:1.7, data:1.3, technology:1.1, process:1.3, value:1.1, trust:1.4 },
  "Energy & industrial": { strategy:1.2, leadership:1.1, people:1.2, data:1.8, technology:1.7, process:1.4, value:1.2, trust:1.2 },
  "Healthcare":          { strategy:1.2, leadership:1.3, people:1.4, data:1.6, technology:1.2, process:1.3, value:1.1, trust:1.5 },
  "Media & technology":  { strategy:1.3, leadership:1.1, people:1.3, data:1.4, technology:1.5, process:1.2, value:1.4, trust:1.2 },
  "SME / Enterprise":    { strategy:1.2, leadership:1.1, people:1.2, data:1.2, technology:1.1, process:1.2, value:1.6, trust:1.1 },
  "Other":               { strategy:1.2, leadership:1.2, people:1.2, data:1.2, technology:1.2, process:1.2, value:1.2, trust:1.2 }
};

/* Illustrative sector medians — pending validation against the live benchmark. */
var BENCH = { strategy:58, leadership:55, people:48, data:42, technology:52, process:45, value:44, trust:50 };
var BENCH_COMPOSITE = 49;

/* ---------- Practice questions (Part 1) ---------- */
function P(id,dim,text,example,matters,wrong,opts){ return {id:id,dim:dim,section:"practice",type:"scale",text:text,example:example,matters:matters,wrong:wrong,opts:opts}; }
var PRACTICE = [
  P("p1","strategy","Is there a written AI plan tied to your business goals?",
    "A written plan naming what AI is for this year, its business objectives, and who owns it.",
    "Every funded AI programme starts with a written plan that someone has signed. Without one, spend scatters.",
    "AI spend scatters across departments with nothing to show at year end.",
    ["No plan","Ideas, nothing written","A slide, not a plan","A written plan","A funded plan tied to business targets"]),
  P("p2","strategy","Who holds the budget and the mandate for AI?",
    "One person the board can ask \u201chow is AI going?\u201d and get an answer.",
    "70% of Middle East CEOs have an AI roadmap. Far fewer have a single person accountable for delivering it.",
    "Everyone assumes someone else owns it, so nothing scales past AI pilot.",
    ["No one","Split across departments","IT owns it by default","A named executive sponsor","A sponsor with budget and a steering group"]),
  P("p3","leadership","Does your board or executive team understand AI well enough to make decisions about it?",
    "Approving an AI investment without needing to take the vendor's word for it.",
    "Boards approve or block AI investment. Their level of understanding sets the ceiling on what you can do.",
    "You either over-buy on hype or freeze on fear — both are expensive.",
    ["Not at all","Aware of the headlines","Some understand","Briefed and confident","Trained, and it shapes strategy"]),
  P("p4","leadership","How is AI funded?",
    "Whether a promising AI pilot has a route to real money, or dies at the end of the trial.",
    "Pilots are cheap. Scaling is not. Money set aside for the second stage is what separates a demo from a system.",
    "Pilots succeed and then stop, because nothing was set aside to scale them.",
    ["No budget","Ad hoc, case by case","A AI pilot budget only","An annual AI budget","Funding over several years, including money to grow what works"]),
  P("p5","people","Are your people trained to use AI in their actual jobs?",
    "A finance analyst and a board member need very different AI training.",
    "AI literacy works when it is matched to the role. Generic training is the most common way to waste a training budget.",
    "Tools go unused, or get used badly — and the spend returns nothing.",
    ["No training","Optional online links","One generic session","Role-based training","Matched to each role, kept current and tracked"]),
  P("p6","people","Can you hire or access the AI skills you need?",
    "Needing someone who can build and run an AI system, not just talk about one.",
    "59% of Middle East CEOs say they can access high-quality technical talent. Using it in-house is what builds lasting capability.",
    "Delivery depends entirely on vendors, and you never build internal capability.",
    ["No access","Vendors only","A few individuals","A small internal team","An internal team plus trusted partners"]),
  P("p7","data","Can your AI tools actually reach the data they need?",
    "The model is fine, but the documents it needs sit in five systems it cannot open.",
    "Only 16% of GCC CEOs say their AI tools can reach all the data they need. This is the region's single biggest brake on AI.",
    "The model works but cannot see what it needs, so the results stay thin.",
    ["No access","Locked in silos","Partial access","Most key data connected","Connected, controlled and up to date"]),
  P("p8","data","Do you trust the quality of the data your AI would use?",
    "Duplicate customer records producing confidently wrong answers.",
    "AI built on poor data produces confident, wrong output that is hard to spot.",
    "Decisions get made on output nobody has checked against reality.",
    ["Untested","Known to be poor","Mixed","Good in key systems","Checked, owned and improving"]),
  P("p9","technology","Do you have a platform for AI, or is every project starting from scratch?",
    "Three teams separately buying three different tools for the same job.",
    "A shared platform is what makes the second AI project cheaper than the first.",
    "Duplicate cost, no reuse, and nothing you build carries forward.",
    ["Nothing","Whatever each team buys","Some shared tools","A standard platform","A shared platform teams can reuse"]),
  P("p10","technology","Can AI connect to the systems people work in every day?",
    "AI that lives in a separate window nobody opens.",
    "AI that sits outside daily systems gets used during the AI pilot and forgotten after it.",
    "Usage collapses the moment the AI pilot enthusiasm fades.",
    ["Not connected","Manual copy-paste","One or two integrations","Integrated into main systems","Embedded in daily workflow"]),
  P("p11","process","When AI is introduced, do you redesign the work around it?",
    "The AI drafts the report, but the same three approvals still take a week.",
    "Automating a step while keeping every approval around it delivers no time saving at all.",
    "You automate one step and keep all the delay — so the benefit never lands.",
    ["Never","We bolt it on","Small tweaks","We redesign key processes","Redesign is standard practice"]),
  P("p12","process","Do you manage the change — communication, resistance, support?",
    "Staff quietly assuming AI is there to replace them.",
    "Adoption is a people problem. Staff who fear AI will not use it, whatever it can do.",
    "The best tool in the world fails against an unconvinced workforce.",
    ["Not managed","An announcement email","Some support","A change plan per rollout","Managing the change is part of every rollout"]),
  P("p13","value","How do you choose which AI use cases to do first?",
    "Picking the idea with the loudest sponsor rather than the biggest return.",
    "Ranking use cases by value and effort is what keeps AI spend pointed at the business.",
    "Effort goes to visible projects instead of valuable ones.",
    ["We don't","Whatever's suggested","A list, unranked","Ranked by value and effort needed","A scored list, kept current and reviewed regularly"]),
  P("p14","value","Do you measure what AI delivers?",
    "Hours saved, errors avoided, revenue gained — with a baseline to compare against.",
    "A programme that cannot show a return is the first thing cut in a budget review.",
    "You cannot defend the budget, and you cannot tell success from noise.",
    ["No measurement","Anecdotes","Usage only \u2014 how often it is used","Business outcomes tracked","Compared against a starting point and reported to the board"]),
  P("p15","trust","Do you have basic rules for how AI is used?",
    "Whether staff may paste client information into a free AI tool.",
    "Staff using free AI tools with work data is the most common cause of data loss today, and a PDPPL exposure.",
    "Client or customer information ends up on a server you do not control.",
    ["No rules","Spoken guidance","A line in a policy","A clear AI use policy","Policy, approved-tools list and training"]),
  P("p16","trust","Do you know every AI tool in use across the organisation?",
    "The tools bought on a departmental card that nobody central knows about.",
    "You cannot govern, secure or scale what you cannot see.",
    "A tool nobody was tracking becomes a problem nobody saw coming.",
    ["No idea","The big ones only","A partial, old list","A maintained list","A current list with owners and risk levels"])
];

/* ---------- Knowledge checks (Part 2) ---------- */
function K(id,text,opts,correct,because,scores,src){ return {id:id,section:"know",type:"knowledge",text:text,opts:opts,correct:correct,because:because,scores:scores,src:src}; }
var KNOW = [
  K("k1","In the Middle East, how many CEOs say their company culture makes it easy to use AI?",
    ["About 2 in 10","About 4 in 10","About 8 in 10","I'm not sure"],2,
    "About 8 in 10 (82%) \u2014 the highest of any region in the world. Wanting to use AI is not your problem. Making it work is.",[20,40,100,0],
    "PwC 29th Global CEO Survey, Middle East findings, January 2026"),
  K("k2","In the Gulf, how many companies say their AI tools can open all the files and data they need?",
    ["Most of them","About half","Fewer than 1 in 5","I'm not sure"],2,
    "Fewer than 1 in 5. It is 16% in the Gulf, 22% across the Middle East and 29% worldwide. Getting AI to your data is the region's biggest problem \u2014 not a lack of interest in AI.",[20,40,100,0],
    "PwC 29th Global CEO Survey, Middle East findings, January 2026"),
  K("k3","Do Middle East companies plan their AI better or worse than the world average?",
    ["Worse","About the same","Better","I'm not sure"],2,
    "Better. About 7 in 10 have a clear AI plan, against 5 in 10 worldwide. The region plans well. The gap appears when the plan has to be delivered.",[20,40,100,0],
    "PwC 29th Global CEO Survey, Middle East findings, January 2026"),
  K("k4","Who sets Qatar's national direction on AI?",
    ["Qatar Central Bank (QCB)","The Ministry of Communications and Information Technology (MCIT)","ISO, the international standards body","I'm not sure"],1,
    "MCIT leads AI for the country. The QCB sets AI rules that banks must follow, and ISO/IEC 42001 is the international standard you can be checked against.",[30,100,30,0],
    "MCIT National AI Policy consultation; GCC AI Regulation Playbook, July 2026")
];

/* ---------- Why it matters (Part 3) ---------- */
function R(id,text,example,lesson,opts){ return {id:id,section:"why",type:"scale",text:text,example:example,lesson:lesson,opts:opts}; }
var WHY = [
  R("r1","Most AI pilots never become part of daily work. If you started one today, how sure are you that people would still be using it in a year?",
    "A chatbot that works in a demo, and six months later is still only a demo.",
    "The technology is almost never the problem. What stops it is having no clear owner, no access to the data, and no change to how the work is done.",
    ["It would stall","Probably not","Maybe","Likely","Yes — we have a route to production"]),
  R("r2","AI is only useful when people change the way they work. How ready are your staff to do that?",
    "A new tool is given to staff, and three months later most of them still work the old way.",
    "This is about skills, not software. Training has to match the job: a front-line employee and a board member need very different things.",
    ["Not ready at all","A few enthusiasts","Mixed by team","Mostly ready","Ready — trained by role"]),
  R("r3","If your CEO asked what last year's spending on AI gave back to the business, could you answer with a number?",
    "At the next board meeting, someone asks what the AI budget has returned.",
    "If you cannot measure it, you cannot defend it. AI work that shows no result is usually the first thing cut from the budget.",
    ["No idea","Anecdotes only","Rough estimate","Measured on some projects","Tracked against a business case"])
];

/* ---------- Blockers gate ---------- */
var BLOCKERS = [
  ["No one owns it","Nobody is named as responsible for AI, and nobody holds the budget.","strategy"],
  ["We can't reach our own data","Data sits in separate systems, or in old systems AI cannot open.","data"],
  ["No pipeline","Ideas come up here and there, and nobody ranks them by value.","value"],
  ["Skills gap","Teams do not know how to use AI, or how to build with it.","people"],
  ["Shadow AI","Staff use free AI tools because there is no approved way to do it properly.","trust"],
  ["No measurement","Nobody can say what AI has given back to the business.","value"],
  ["AI pilot purgatory","Things work in a trial and never grow beyond it.","process"]
];


var BLOCKER_WHY = {
  "No one owns it":"Without a single accountable owner, AI moves at the speed of whoever has spare time. Decisions wait for a meeting nobody schedules, the budget is defended by no one, and initiatives stop the moment their internal champion changes role.",
  "We can't reach our own data":"The most expensive blocker on this list, because it is the slowest to clear. Connecting systems, resolving ownership and cleaning source data take quarters rather than weeks, so every month of delay pushes the entire programme back by the same amount.",
  "No pipeline":"When ideas arrive informally, what gets built is whatever was asked for loudest rather than whatever returns most. Effort spreads thinly across small initiatives, none reaches production, and there is nothing to show at the year end.",
  "Skills gap":"Tools without capability become licences nobody uses. It also creates dependency: every change needs a vendor, costs stay variable, and internal knowledge never accumulates.",
  "Shadow AI":"Staff will use AI whether or not you provide it. Where there is no approved route, work data ends up in tools you neither control nor can audit \u2014 the most common cause of AI-related data loss today, and a direct PDPPL exposure.",
  "No measurement":"Without a baseline, success and noise look identical. The programme cannot be defended at budget time and cannot be extended on evidence, so funding decisions get made on impressions.",
  "AI pilot purgatory":"The single most common failure pattern in AI. The cause is rarely the technology; it is what sits around it \u2014 no production owner, no data access, no change to the workflow, and no measurement to justify going further."
};

/* A narrative reading of the blockers, rather than a list. */
function blockerNarrative(R){
  var n=S.blockers.length;
  if(!n) return "You did not identify any blockers, which is unusual and worth treating as a finding in itself. Either the organisation is genuinely unobstructed \u2014 in which case the roadmap above is a matter of sequencing rather than unblocking \u2014 or the constraints have not yet surfaced because AI has not been pushed hard enough to reveal them. Re-run this assessment once delivery is underway; blockers tend to appear at the point of scaling, not at the point of planning.";
  var pillars={};
  S.blockers.forEach(function(b){
    var row=BLOCKERS.filter(function(x){ return x[0]===b; })[0];
    PILLARS.forEach(function(p){ if(p.dims.indexOf(row[2])>=0) pillars[p.name]=true; });
  });
  var names=Object.keys(pillars);
  var where = (n===1) ? "It sits under <b>"+names[0]+"</b>."
            : names.length===1 ? "All of them sit under a single pillar, <b>"+names[0]+"</b>, which makes the remedy unusually focused: concentrated effort in one area would clear the whole set."
            : "They span "+names.length+" of the four pillars \u2014 "+names.slice(0,-1).join(", ")+" and "+names[names.length-1]+" \u2014 which is why they are unlikely to resolve individually. Work in one pillar tends to stall against an unresolved constraint in another.";
  var weight = n>=4 ? "Four or more blockers at once is not a delivery problem but a structural one. Addressing them in isolation will not work; they need to be sequenced deliberately, which is what the roadmap above sets out."
             : (n===1 ? "A single named blocker is the best position to be in: the constraint is known, bounded, and can be cleared before it compounds into others."
                      : "At this number the blockers are still tractable, provided they are cleared before further AI investment is committed.");
  return "You identified <b>"+n+"</b> of the seven constraints below as active in your organisation"+(n===1?"":"")+". "+where+" "+weight;
}

var GATE = { id:"gate", section:"gate" };
var STEPS = PRACTICE.concat(KNOW).concat(WHY).concat([GATE]);

var FIX = {
  strategy:"Establish executive-level ownership of AI and a funded plan tied to business objectives, rather than accountability distributed across functions.",
  leadership:"Build genuine board-level understanding of AI, and secure funding that covers scaling and not only AI pilots.",
  people:"Establish an AI capability programme differentiated by role and seniority, and build internal capacity rather than depending on vendors.",
  data:"Establish the data foundations AI depends on \u2014 access, quality and ownership across the systems that matter most to your use cases.",
  technology:"Consolidate onto a shared AI platform integrated with the systems people already work in, so capability compounds instead of fragmenting.",
  process:"Redesign the workflows AI touches, and manage the organisational change that adoption depends on.",
  value:"Put a value framework in place \u2014 prioritisation criteria, baselines and board-level reporting on what AI returns.",
  trust:"Establish the governance basics: an AI use policy, controlled tooling, and a maintained register of every AI system in use."
};

var LANG = {
  en:{ begin:"Begin", next:"Next", back:"Back", results:"See my snapshot", restart:"Restart",
       report:"Board report", print:"Print / Save as PDF", cont:"Continue" },
  ar:{ begin:"ابدأ", next:"التالي", back:"السابق", results:"عرض اللمحة السريعة", restart:"إعادة",
       report:"تقرير مجلس الإدارة", print:"طباعة / حفظ PDF", cont:"متابعة" }
};

/* ============================ state ============================ */
var KEY = "c1rd_public_v3";
var S = {
  lang:"en", screen:"intro", sectors:[], otherSector:"", country:"", otherCountry:"",
  size:"", role:"", usage:"", aiTypes:[], riskClass:"", riskProcess:"", consent:false,
  answers:{}, unsure:{}, blockers:[], step:0, email:"", submitted:false,
  cWant:0, cName:"", cOrg:"", cEmail:"", cRole:"", cSector:"", cMsg:"", sendErr:""
};
var AID = (window.crypto && crypto.randomUUID) ? crypto.randomUUID() : "a-"+Date.now().toString(36);
var SENT = false;

function save(){ try{ localStorage.setItem(KEY, JSON.stringify(S)); }catch(e){} }
function load(){ try{ var r=localStorage.getItem(KEY); if(r){ var o=JSON.parse(r); for(var k in o){ if(k in S) S[k]=o[k]; } } }catch(e){} }
function reset(){ try{ localStorage.removeItem(KEY); }catch(e){}
  S.sectors=[];S.otherSector="";S.country="";S.otherCountry="";S.size="";S.role="";S.usage="";
  S.aiTypes=[];S.riskClass="";S.riskProcess="";S.consent=false;S.answers={};S.unsure={};
  S.blockers=[];S.step=0;S.email="";S.submitted=false;
  S.cWant=0;S.cName="";S.cOrg="";S.cEmail="";S.cRole="";S.cSector="";S.cMsg="";S.sendErr=""; go("intro"); }

function esc(s){ return String(s).replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;"); }
function T(){ return LANG[S.lang]; }
function preAdoption(){ return S.usage === "No current AI usage"; }
function sectorText(){
  if(!S.sectors.length) return "Not specified";
  return S.sectors.map(function(x){ return (x==="Other" && S.otherSector) ? "Other ("+S.otherSector+")" : x; }).join(", ");
}
function today(){ return new Date().toLocaleDateString("en-GB",{day:"numeric",month:"long",year:"numeric"}); }

/* ============================ scoring ============================ */
function val(q){
  var a = S.answers[q.id];
  if(a===undefined || a===null) return 0;
  if(S.unsure[q.id]) return 0;
  if(q.type==="knowledge") return q.scores[a];
  return a*25;
}
function answered(q){ return S.answers[q.id]!==undefined && S.answers[q.id]!==null; }

function compute(){
  var d={}, i, j;
  for(i=0;i<DIMS.length;i++){
    var qs = PRACTICE.filter(function(q){ return q.dim===DIMS[i].key; });
    var sum=0; for(j=0;j<qs.length;j++) sum+=val(qs[j]);
    d[DIMS[i].key] = Math.round(sum/qs.length);
  }
  var groups = S.sectors.length ? S.sectors.map(function(s){ return SECTOR_GROUP[s]||"Other"; }) : ["Other"];
  var w={}, num=0, den=0;
  for(i=0;i<DIMS.length;i++){
    var k=DIMS[i].key, t=0;
    for(j=0;j<groups.length;j++) t += WEIGHTS[groups[j]][k];
    w[k]=t/groups.length; num += d[k]*w[k]; den += w[k];
  }
  var composite = Math.round(num/den);
  var know = Math.round(KNOW.map(val).reduce(function(a,b){return a+b;},0)/KNOW.length);
  var why  = Math.round(WHY.map(val).reduce(function(a,b){return a+b;},0)/WHY.length);

  var pil = PILLARS.map(function(p){
    var v = Math.round(p.dims.reduce(function(a,k){ return a+d[k]; },0)/p.dims.length);
    return { n:p.n, name:p.name, colour:p.colour, dims:p.dims, cta:p.cta, value:v };
  });
  var weakPillar = pil.slice().sort(function(a,b){ return a.value-b.value; })[0];
  var gaps = DIMS.slice().sort(function(a,b){ return d[a.key]-d[b.key]; });

  /* roadmap */
  var blockDim = {}; S.blockers.forEach(function(b){ BLOCKERS.forEach(function(x){ if(x[0]===b) blockDim[x[2]]=x[0]; }); });
  var now=[], six=[], twelve=[];
  now.push({ t:gaps[0].label, d:FIX[gaps[0].key], s:d[gaps[0].key] });
  if(d.strategy<70) now.push({ t:"Establish accountability", d:"Executive-level ownership of AI, with the mandate and budget to act on it.", s:d.strategy });
  if(d.trust<70)    now.push({ t:"Set the ground rules", d:"Baseline policy and controlled tooling \u2014 the fastest way to reduce exposure while the wider programme is built.", s:d.trust });
  if(!now.some(function(x){return x.t==="AI register";}) && d.trust<80)
    now.push({ t:"Establish visibility", d:"A maintained inventory of AI in use, with owners and risk levels. Every other control depends on it.", s:d.trust });

  six.push({ t:gaps[1].label, d:FIX[gaps[1].key], s:d[gaps[1].key] });
  six.push({ t:gaps[2].label, d:FIX[gaps[2].key], s:d[gaps[2].key] });
  if(d.data<70)       six.push({ t:"Establish data foundations", d:"Access, quality and ownership across the systems AI depends on. This carries the longest lead time of anything here.", s:d.data });
  if(d.technology<70) six.push({ t:"Consolidate the platform", d:"A shared foundation, so capability compounds across initiatives instead of being rebuilt each time.", s:d.technology });

  if(d.value<80)      twelve.push({ t:"Institutionalise measurement", d:"Baselines, business cases and board reporting, so the programme can be defended and extended.", s:d.value });
  if(d.process<80)    twelve.push({ t:"Scale what proved out", d:"Move validated AI pilots into production with the surrounding workflow properly redesigned.", s:d.process });
  if(pil[1].value<70) twelve.push({ t:"Begin the ISO 42001 pathway", d:"An AI management system turns readiness into something you can evidence to partners, regulators and clients.", s:pil[1].value });
  if(!twelve.length)  twelve.push({ t:"Protect the position", d:"Keep evidence current, re-assess as the AI estate grows, and bring every new system inside the same controls.", s:composite });

  return { d:d, composite:composite, know:know, why:why, pillars:pil, weakPillar:weakPillar,
           gaps:gaps, band:band(composite), roadmap:{now:now.slice(0,4), six:six.slice(0,4), twelve:twelve.slice(0,3)},
           blockDim:blockDim };
}

/* ============================ svg ============================ */
function polar(cx,cy,r,deg){ var a=deg*Math.PI/180; return [cx+r*Math.cos(a), cy+r*Math.sin(a)]; }
function arc(cx,cy,r,a1,a2){ var p=polar(cx,cy,r,a1), q=polar(cx,cy,r,a2);
  return "M "+p[0]+" "+p[1]+" A "+r+" "+r+" 0 "+((a2-a1<=180)?0:1)+" 1 "+q[0]+" "+q[1]; }

function gauge(score){
  var b=band(score), needle=180+score/100*180, n=polar(160,150,98,needle), out="";
  BANDS.forEach(function(s){
    var a=180+s.min/100*180, c=180+(s.max+(s.max===100?0:1))/100*180;
    out += '<path d="'+arc(160,150,118,a,c)+'" fill="none" stroke="'+s.color+'" stroke-width="16"/>';
  });
  return '<svg viewBox="0 0 320 182" width="100%" style="max-width:380px;display:block;margin:0 auto" role="img" aria-label="Readiness score '+score+' out of 100">'
    + out
    + '<line x1="160" y1="150" x2="'+n[0]+'" y2="'+n[1]+'" stroke="#1F1D1C" stroke-width="4" stroke-linecap="round"/>'
    + '<circle cx="160" cy="150" r="8" fill="#1F1D1C"/>'
    + '<text x="160" y="106" fill="'+b.color+'" style="font-family:var(--mono)" font-size="54" font-weight="800" text-anchor="middle">'+score+'</text>'
    + '<text x="160" y="128" fill="#6B6866" style="font-family:var(--mono)" font-size="10" font-weight="700" text-anchor="middle" letter-spacing="2">/ 100</text></svg>';
}

function radar(d, size){
  size = size || 300;
  var cx=size/2, cy=size/2, R=size*0.33, n=DIMS.length, rings="", axes="", labs="", pts=[], bpts=[];
  for(var g=1; g<=4; g++){
    var rr=R*g/4, poly=[];
    for(var i=0;i<n;i++){ var p=polar(cx,cy,rr,-90+i*360/n); poly.push(p[0].toFixed(1)+","+p[1].toFixed(1)); }
    rings += '<polygon points="'+poly.join(" ")+'" fill="none" stroke="#BDBBB9" stroke-width="1"/>';
  }
  for(i=0;i<n;i++){
    var ang=-90+i*360/n, e=polar(cx,cy,R,ang), lp=polar(cx,cy,R+(size>260?20:16),ang);
    axes += '<line x1="'+cx+'" y1="'+cy+'" x2="'+e[0]+'" y2="'+e[1]+'" stroke="#BDBBB9" stroke-width="1"/>';
    var anchor = Math.abs(lp[0]-cx)<3 ? "middle" : (lp[0]>cx ? "start" : "end");
    labs += '<text x="'+lp[0].toFixed(1)+'" y="'+(lp[1]+4).toFixed(1)+'" text-anchor="'+anchor+'" fill="#3F3D3B" font-size="'+(size>260?11:9.5)+'" font-weight="600">'+DIMS[i].label+'</text>';
    var v=polar(cx,cy,R*Math.max(d[DIMS[i].key],2)/100,ang); pts.push(v[0].toFixed(1)+","+v[1].toFixed(1));
    var bv=polar(cx,cy,R*BENCH[DIMS[i].key]/100,ang); bpts.push(bv[0].toFixed(1)+","+bv[1].toFixed(1));
  }
  var pad=Math.round(size*0.17);
  return '<svg viewBox="'+(-pad)+' '+(-pad*0.35)+' '+(size+pad*2)+' '+(size+pad*0.7)+'" width="100%" style="max-width:'+(size+pad)+'px;display:block;margin:0 auto" role="img" aria-label="Readiness profile across eight areas">'
    + rings + axes
    + '<polygon points="'+bpts.join(" ")+'" fill="none" stroke="#6B6866" stroke-width="1.5" stroke-dasharray="4 3"/>'
    + '<polygon points="'+pts.join(" ")+'" fill="#B31B0C" fill-opacity=".24" stroke="#B31B0C" stroke-width="2.5"/>'
    + labs + '</svg>';
}

function barHTML(v, showBench, benchVal){
  var b=band(v);
  var mark = showBench ? '<span class="bench" style="left:calc('+benchVal+'% - 1px)" title="Sector median '+benchVal+'"></span>' : "";
  return '<div class="bar-wrap"><div class="bar-track"><div class="bar-fill" style="width:'+v+'%;background:'+b.color+'"></div></div>'+mark+'</div>';
}

/* ============================ nav ============================ */
function go(screen){ S.screen=screen; save(); render(); window.scrollTo(0,0); }
function toggleLang(){ S.lang = (S.lang==="en") ? "ar" : "en";
  document.getElementById("langBtn").textContent = (S.lang==="en") ? "العربية" : "EN"; render(); }

function pick(field,v){ S[field]=v; save(); render(); }
function toggleIn(field,v){ var a=S[field], i=a.indexOf(v); if(i>=0) a.splice(i,1); else a.push(v); save(); render(); }
function setText(field,v){ S[field]=v; save(); }
function setConsent(v){ S.consent=v; save(); render(); }

function answer(id,i){ S.answers[id]=i; if(S.unsure[id]) delete S.unsure[id]; save(); render(); }
function markUnsure(id){ S.answers[id]=0; S.unsure[id]=true; save(); render(); }
function stepTo(i){ S.step=i; save(); render(); window.scrollTo(0,0); }

/* ============================ intro ============================ */
function introHTML(){
  var h = '<div class="wrap wide" style="padding-bottom:70px">';
  h += '<div style="padding-top:54px">'
    + '<div class="eyebrow blue">Cypher-One presents</div>'
    + '<h1 style="font-size:58px;line-height:1;font-weight:900;margin:14px 0 10px"><span style="color:var(--navy)">Cypher-One </span><span style="color:var(--brass)">AI Readiness</span></h1>'
    + '<p style="font-size:24px;line-height:1.3;font-weight:700;color:var(--blue);margin:0 0 16px">'+TAGLINE+'</p>'
    + '<div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin:0 0 20px">'
      + '<span style="display:inline-flex;align-items:center;gap:8px;background:var(--navy);color:#fff;font-family:var(--mono);font-size:12.5px;font-weight:700;letter-spacing:1.5px;text-transform:none;border-radius:0;padding:8px 16px">AI Readiness Assessment</span>'
      + '<span class="meta" style="color:var(--mute)">'+VERSION+'</span></div>'
    + '<p style="font-size:18.5px;line-height:1.6;color:var(--steel);margin:0 0 14px;max-width:820px">Are you ready to adopt AI? Find out how your organisation scores across the eight areas that decide whether AI reaches daily use or stalls in AI pilot. Get your <b>readiness snapshot</b> in about ten minutes, then set up a session with us for your <b>full report</b>.</p>'
    + '<p style="font-size:16px;line-height:1.55;color:var(--navy);margin:0;font-weight:600;max-width:820px">Middle East organisations plan AI better than almost anywhere. The gap opens at delivery.</p>'
    + '<div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;margin-top:22px">'
      + '<button class="btn-brass arrow" style="font-size:15px" onclick="jump()">Start the assessment </button>'
      + '<span class="meta">~10 min · '+STEPS.length+' steps · instant snapshot · no sign-in</span></div></div>';

  h += '<div style="text-align:center;max-width:720px;margin:40px auto 0">'
    + '<h2 style="font-size:28px;font-weight:800;color:var(--navy);margin:0 0 8px;letter-spacing:-.4px">Why use the AI Readiness Checker?</h2>'
    + '<p style="font-size:17px;color:var(--steel);line-height:1.55;margin:0">See where your organisation actually stands, against the eight areas that decide whether AI delivers — and what to fix first.</p></div>';

  h += '<div class="navy-panel"><h2>Why AI readiness?</h2>'
    + '<p style="font-family:var(--mono);font-size:14px;font-weight:700;letter-spacing:2px;color:var(--brass);text-transform:uppercase;margin:0 0 10px;line-height:1.4">Ambition is not the constraint. Execution is.</p>'
    + '<p style="font-size:17.5px;color:var(--steel);margin:0 0 26px;font-weight:500;line-height:1.5">Most organisations know they need AI. Far fewer have what it takes to make it work.</p><div class="six">';
  SIX.forEach(function(x,i){
    h += '<div class="six-item"><span class="six-num">'+(i+1)+'</span><div><div class="six-h">'+x[0]+'</div><div class="six-b">'+x[1]+'</div></div></div>';
  });
  h += '</div><div style="margin-top:26px;padding-top:20px;border-top:1px solid #C9C6C3;font-size:17px;color:var(--ink);font-weight:600;line-height:1.55">Cypher-One works across all six — strategy, people, data, technology, workflow and value — so readiness becomes a programme, not a plan.</div></div>';

  h += '<h2 style="font-size:24px;font-weight:800;color:var(--navy);margin:42px 0 4px">Real AI projects that failed — and why</h2>'
    + '<p style="font-size:16.5px;color:var(--steel);margin:0 0 18px">These are real companies. Each had the budget, the people and the technology. What they lacked was readiness.</p><div class="cases">';
  CASES.forEach(function(c,i){
    var col=CASE_C[i%CASE_C.length];
    h += '<div class="case" onclick="toggleOpen(this)" style="border-left:6px solid '+col.b+'"><h3>'+c.t+'</h3><p>'+c.s+'</p>'
      + '<div class="cost" style="background:'+col.bg+';color:'+col.t+'"><span style="flex:0 0 auto;color:'+col.b+';font-size:17px;line-height:1.2">\u26A0</span>'
      + '<span><b>What it cost:</b> '+c.c+'</span></div><span class="more" data-o="Read the story +">Read the story +</span></div>';
  });
  h += '</div>';

  h += '<h2 style="font-size:24px;font-weight:800;color:var(--navy);margin:42px 0 6px">The five frameworks your readiness is judged against</h2>'
    + '<p style="font-size:16.5px;color:var(--steel);margin:0 0 18px">Readiness is not only an internal question. These are the reference points your board, your regulator and your partners will use.</p><div class="anchors">';
  ANCHORS.forEach(function(a){
    h += '<div class="anchor" onclick="toggleOpen(this)" style="border-top:4px solid '+a[1]+'"><h4 style="color:'+a[1]+'">'+a[0]+'</h4><p>'+a[2]+'</p>'
      + '<div class="who"><span>Why it matters to you</span><div style="font-size:12px;font-weight:600;color:'+a[1]+';line-height:1.4">'+a[3]+'</div></div><span class="more" data-o="More +">More +</span></div>';
  });
  h += '</div>';

  /* start card — sectors + consent */
  h += '<div class="card" id="startCard" style="padding:30px;margin-top:34px;max-width:580px">'
    + '<h2 style="font-size:30px;font-weight:900;color:var(--navy);letter-spacing:-.6px;margin:0 0 6px">Start the assessment</h2>'
    + '<p style="font-size:17px;color:var(--steel);margin:0 0 20px;line-height:1.5">About ten minutes. No sign-in. You’ll get your readiness snapshot at the end. Your full report comes with a session with our team.</p>'
    + '<label style="display:block;font-size:18px;font-weight:700;color:var(--navy);margin:0 0 3px">Which sectors do you operate in?</label>'
    + '<div style="font-size:13.5px;color:var(--mute);margin-bottom:12px">Select all that apply.</div><div class="grid2">';
  SECTORS.forEach(function(s){
    var on=S.sectors.indexOf(s)>=0;
    h += '<button class="opt'+(on?" on":"")+'" style="font-size:15px;padding:12px 14px" onclick="toggleIn(\'sectors\','+JSON.stringify(s).replace(/"/g,"&quot;")+')"><span class="box">'+(on?"✓":"")+'</span>'+s+'</button>';
  });
  h += '</div>';
  if(S.sectors.indexOf("Other")>=0)
    h += '<input type="text" style="margin-top:10px" placeholder="Type your industry (e.g. logistics, tourism)…" value="'+esc(S.otherSector)+'" oninput="setText(\'otherSector\',this.value)">';
  h += '<label style="display:flex;gap:9px;align-items:flex-start;margin:16px 0 4px;cursor:pointer">'
    + '<input type="checkbox" style="margin-top:4px;width:16px;height:16px"'+(S.consent?" checked":"")+' onchange="setConsent(this.checked)">'
    + '<span style="font-size:13.5px;color:var(--steel);line-height:1.5">I understand this is a readiness check, not legal advice or certification. I agree that my responses may be stored and used in anonymised, aggregated form to build industry benchmarks. No information identifying me or my organisation is required to see my snapshot. <span style="color:var(--mute);font-style:italic">[Placeholder consent — pending legal review]</span></span></label>';
  var ok = S.consent && S.sectors.length>0;
  h += '<button class="'+(ok?"btn-navy":"")+' arrow" style="width:100%;justify-content:center;margin-top:14px;font-size:15px"'+(ok?"":" disabled")+' onclick="go(\'profile\')">'+T().begin+' </button>';
  if(S.consent && !S.sectors.length) h += '<div style="font-size:13px;color:var(--mute);text-align:center;margin-top:8px">Select at least one sector to begin.</div>';
  h += '</div></div>';
  return h;
}
function jump(){ var el=document.getElementById("startCard"); if(el) el.scrollIntoView({behavior:"smooth",block:"start"}); }

/* ============================ profile ============================ */
function fieldCard(title,sub,inner){
  return '<div class="card" style="padding:24px;margin-bottom:16px">'
    + '<div style="font-size:17.5px;font-weight:700;color:var(--navy);margin-bottom:'+(sub?"3px":"12px")+'">'+title+'</div>'
    + (sub?'<div style="font-size:13.5px;color:var(--mute);margin-bottom:12px">'+sub+'</div>':"")
    + inner + '</div>';
}
function chips(list,field){
  return '<div class="row">'+list.map(function(x){
    return '<button class="chip'+(S[field]===x?" on":"")+'" onclick="pick(\''+field+'\','+JSON.stringify(x).replace(/"/g,"&quot;")+')">'+x+'</button>';
  }).join("")+'</div>';
}
function radios(list,field){
  return '<div class="stack">'+list.map(function(x){
    var on=S[field]===x;
    return '<button class="opt'+(on?" on":"")+'" onclick="pick(\''+field+'\','+JSON.stringify(x).replace(/"/g,"&quot;")+')"><span class="dot"></span>'+x+'</button>';
  }).join("")+'</div>';
}
function checks(list,field){
  return '<div class="grid2">'+list.map(function(x){
    var on=S[field].indexOf(x)>=0;
    return '<button class="opt'+(on?" on":"")+'" style="font-size:14.5px;padding:11px 13px" onclick="toggleIn(\''+field+'\','+JSON.stringify(x).replace(/"/g,"&quot;")+')"><span class="box">'+(on?"✓":"")+'</span>'+x+'</button>';
  }).join("")+'</div>';
}

function profileHTML(){
  var h='<div class="wrap narrow" style="padding-bottom:70px"><div style="padding-top:32px">'
    + '<div class="eyebrow blue">Before we start</div>'
    + '<h1 style="font-size:30px;font-weight:900;color:var(--navy);letter-spacing:-.6px;margin:10px 0 6px">A few quick questions about your AI</h1>'
    + '<p style="font-size:16px;color:var(--steel);margin:0 0 24px;line-height:1.5">This helps us tailor your snapshot. It takes under a minute.</p>';

  h += fieldCard("Where is your organisation primarily based?","This sets which frameworks we focus on for you.",
        chips(COUNTRIES,"country") + (S.country==="Other" ? '<input type="text" style="margin-top:10px" placeholder="Type your country" value="'+esc(S.otherCountry)+'" oninput="setText(\'otherCountry\',this.value)">' : ""));
  h += fieldCard("How many people work in your organisation?","",chips(SIZES,"size"));
  h += fieldCard("Which best describes your role?","Optional.",chips(ROLES,"role"));
  h += fieldCard("Are you currently using AI systems?","",radios(USAGE,"usage"));
  h += fieldCard("What types of AI do you use?","Select all that apply.",checks(AITYPES,"aiTypes"));

  var rc='<div style="background:var(--faint);border-radius:0;padding:12px 14px;margin-bottom:14px;font-size:12.5px;color:var(--steel);line-height:1.55">'
    + '<b style="color:var(--navy)">Risk levels:</b> <b>Unacceptable</b> — banned uses. <b>High</b> — safety, rights or critical areas (hiring, credit, health). <b>Limited</b> — needs transparency (chatbots). <b>Minimal</b> — most other apps.</div><div class="stack">';
  RISKCLASS.forEach(function(r){
    var on=S.riskClass===r[0], hi=(r[0]==="High-Risk AI");
    rc += '<button class="opt'+(hi?" danger":"")+(on?" on":"")+'" style="align-items:flex-start" onclick="pick(\'riskClass\','+JSON.stringify(r[0]).replace(/"/g,"&quot;")+')">'
      + '<span class="dot" style="margin-top:3px"></span><span><span style="font-size:16px;font-weight:700;display:block">'+r[0]+'</span>'
      + '<span style="font-size:13.5px;color:var(--mute);line-height:1.45;display:block;margin-top:2px">'+r[1]+'</span></span></button>';
  });
  rc+='</div>';
  h += fieldCard("How would you classify your AI's risk?","The EU AI Act sorts AI by risk level. Pick the closest.",rc);
  h += fieldCard("Do you have a well-developed AI strategy?","A written plan for how your organisation will use AI, agreed at senior level.",radios(RISKPROC,"riskProcess"));

  var ok = S.country && S.usage && S.riskClass;
  h += '<div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">'
    + '<button class="btn-ghost" onclick="go(\'intro\')">'+T().back+'</button>'
    + '<button class="'+(ok?"btn-navy":"")+' arrow"'+(ok?"":" disabled")+' onclick="startAssess()">'+T().cont+' — '+STEPS.length+' steps </button></div>';
  if(!ok) h += '<div style="font-size:13px;color:var(--mute);margin-top:8px">Please answer country, AI usage and risk classification to continue.</div>';
  h += '</div></div>';
  return h;
}
function startAssess(){ S.step=0; go("assess"); }

/* ============================ assessment ============================ */
var PARTS = ["Your practice","What good looks like","Why it matters"];
var PART_COL = ["#2E2B2A","#8C2B1E","#5A5653"]; /* v1.13: soft charcoal, muted brick red, warm grey */
function partIndex(q){ return q.section==="practice" ? 0 : (q.section==="know" ? 1 : 2); }

function assessHTML(){
  var q = STEPS[S.step], pi = partIndex(q), accent = (q.section==="gate") ? "#E8321A" : PART_COL[pi];
  var h = '<div class="wrap narrow" style="padding-bottom:64px"><div style="padding-top:28px">';

  /* stepper */
  h += '<div class="stepper">';
  PARTS.forEach(function(p,i){
    var done=i<pi, cur=i===pi, on=done||cur, col=PART_COL[i];
    h += '<div class="stepcol"><div class="stepdot" style="'+(on?"background:"+col+";border-color:"+col+";color:#fff;":"")+(cur?"box-shadow:0 0 0 5px "+col+"2E;":"")+'">'+(done?"✓":(i+1))+'</div>'
      + '<div class="steplab" style="'+(on?"color:"+col+";font-weight:"+(cur?800:600)+";":"")+'">'+p+'</div></div>';
    if(i<PARTS.length-1) h += '<div class="stepline" style="'+(i<pi?"background:"+PART_COL[i]:"")+'"></div>';
  });
  h += '</div>';

  /* progress line */
  var label;
  if(q.section==="practice"){
    var di=0; for(var i=0;i<DIMS.length;i++){ if(DIMS[i].key===q.dim) di=i; }
    label = "Dimension "+(di+1)+" of 8 · "+DIMS[di].label;
  } else if(q.section==="know"){ label="What good looks like";
  } else if(q.section==="why"){ label="Why it matters"; } else { label="What's stalling you?"; }
  h += '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:9px">'
    + '<div class="eyebrow" style="color:'+accent+'">'+label+'</div>'
    + '<div style="font-family:var(--mono);font-size:12px;font-weight:700;color:var(--mute)">'+(S.step+1)+' / '+STEPS.length+'</div></div>'
    + '<div class="bar-track" style="height:6px;margin-bottom:20px"><div style="width:'+(S.step/STEPS.length*100)+'%;height:100%;background:var(--blue);border-radius:0;transition:width .3s ease"></div></div>';

  if(q.section==="know")
    h += '<div style="display:flex;gap:9px;align-items:center;background:#EDEDED;border-radius:0;padding:10px 14px;margin-bottom:20px">'
      + '<span style="color:var(--blue);font-weight:800">i</span><span style="font-size:14px;color:var(--steel)">Quick knowledge checks — <b>one try each</b>. Don\'t worry if you\'re unsure; you\'ll learn the answer.</span></div>';

  if(q.section==="practice" && preAdoption())
    h += '<div class="prealert"><b>Not using AI yet?</b>&nbsp;Answer for how you would handle this if you deployed AI in the next year.</div>';

  h += (q.section==="gate") ? gateHTML() : questionHTML(q,accent);
  h += '</div></div>';
  return h;
}

function questionHTML(q,accent){
  var a = S.answers[q.id], has = answered(q), locked = (q.type==="knowledge" && has);
  var h = '<div class="qcard"><div class="qhead" style="background:'+accent+';border-inline-start:6px solid #E8321A">'
    + '<div style="display:flex;align-items:center;gap:9px;margin-bottom:12px">'
    + '<span style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:0;background:rgba(255,255,255,.16);color:#fff;font-weight:800">'
    + (q.section==="practice"?"◆":(q.section==="know"?"⚖":"⚡"))+'</span>'
    + '<span class="tag">'+(q.section==="practice"?"Your practice":(q.section==="know"?"What good looks like":"Why it matters"))+'</span></div>'
    + '<h2>'+q.text+'</h2>'
    + (q.example?'<p class="ex">'+q.example+'</p>':"")+'</div>';

  h += '<div class="qbody"><div class="stack">';
  q.opts.forEach(function(o,i){
    var sel = (a===i && !S.unsure[q.id]);
    var cls = "opt";
    if(q.type==="knowledge" && has){
      if(i===q.correct) cls += " right";
      else if(sel) cls += " wrong";
      else cls += " locked";
    } else if(sel) cls += " on";
    h += '<button class="'+cls+'"'+(locked?" disabled":"")+' onclick="answer(\''+q.id+'\','+i+')"><span class="dot"></span>'+o+'</button>';
  });
  h += '</div>';

  if(q.section==="practice")
    h += '<button class="unsure'+(S.unsure[q.id]?" on":"")+'" onclick="markUnsure(\''+q.id+'\')">ⓘ &nbsp;I\'m not sure / Don\'t know</button>';

  if(q.type==="knowledge" && has){
    var right = a===q.correct;
    h += '<div style="margin-top:14px;background:'+(right?"#EAF5EF":"#F7F2F0")+';border-left:5px solid '+(right?"#2C6E5B":"var(--brass)")+';border-radius:0;padding:14px 16px">'
      + '<div style="font-size:15.5px;color:var(--ink);line-height:1.5"><b>'+(right?"Correct. ":"Answer: "+q.opts[q.correct]+". ")+'</b>'+q.because+'</div>'
      + '<div style="font-family:var(--mono);font-size:10.5px;color:var(--mute);margin-top:8px;letter-spacing:.5px">Source · '+q.src+'</div></div>';
  }
  if(q.section==="why" && has && q.lesson){
    h += '<div style="margin-top:14px;background:#F7F2F0;border-left:5px solid var(--brass);border-radius:0;padding:15px 17px">'
      + '<div class="lab" style="font-family:var(--mono);font-size:12px;font-weight:800;letter-spacing:1.5px;color:var(--brass);text-transform:none;margin-bottom:7px">The lesson</div>'
      + '<div style="font-size:15.5px;color:var(--navy);line-height:1.45">'+q.lesson+'</div></div>';
  }
  h += '</div>';

  if(q.section==="practice"){
    h += '<div class="qfoot"><div class="note" style="border-left:5px solid var(--brass)">'
      + '<div class="lab" style="color:var(--brass)">⚖ Why this matters</div><div class="txt">'+q.matters+'</div></div>';
    if(has) h += '<div class="note" style="border-left:5px solid var(--red)">'
      + '<div class="lab" style="color:var(--red)">\u26A0 What this costs you</div><div class="txt">'+q.wrong+'</div></div>';
    h += '</div>';
  }

  var last = S.step===STEPS.length-1;
  h += '<div class="qnav"><button class="btn-ghost" style="'+(S.step===0?"opacity:.4":"")+'"'+(S.step===0?" disabled":"")+' onclick="stepTo('+(S.step-1)+')">'+T().back+'</button>'
    + '<button class="'+(has?"btn-navy":"")+' arrow"'+(has?"":" disabled")+' onclick="'+(last?"finish()":"stepTo("+(S.step+1)+")")+'">'+(last?T().results:T().next)+' </button></div></div>';
  return h;
}

function gateHTML(){
  var h = '<div class="qcard"><div class="qhead" style="background:var(--red)">'
    + '<div style="display:flex;gap:11px;align-items:center"><span style="color:#fff;font-weight:800;font-size:20px">⚑</span>'
    + '<h2>What\'s stalling your AI?</h2></div>'
    + '<p style="font-size:15.5px;color:#F6DED7;margin:10px 0 0 33px;line-height:1.5">Tick anything that applies — or none. These don\'t reduce your score. They shape what we tell you to fix first.</p></div>'
    + '<div class="qbody"><div class="stack">';
  BLOCKERS.forEach(function(b){
    var on=S.blockers.indexOf(b[0])>=0;
    h += '<button class="opt danger'+(on?" on":"")+'" style="align-items:flex-start" onclick="toggleIn(\'blockers\','+JSON.stringify(b[0]).replace(/"/g,"&quot;")+')">'
      + '<span class="box" style="margin-top:2px">'+(on?"✓":"")+'</span><span><span style="font-size:16.5px;font-weight:700;display:block">'+b[0]+'</span>'
      + '<span style="font-size:14px;color:var(--steel);display:block;margin-top:3px;line-height:1.45">'+b[1]+'</span></span></button>';
  });
  h += '</div></div><div class="qnav"><button class="btn-ghost" onclick="stepTo('+(S.step-1)+')">'+T().back+'</button>'
    + '<button class="btn-navy arrow" onclick="finish()">'+(S.blockers.length?T().results:"None — "+T().results.toLowerCase())+' </button></div></div>';
  return h;
}
function finish(){ S.submitted=false; S.sendErr=""; go("report"); }
/* ============================ snapshot (v3) ============================ */
/* SETUP: paste the Web3Forms access key for the Cypher-One inbox here. */
var WEB3FORMS_KEY = C1A.web3formsKey || "PASTE-YOUR-WEB3FORMS-ACCESS-KEY";
var WANTS = ["A 30-minute session to walk through my full report",
  "An in-depth readiness review across strategy, data, governance, process and people",
  "An AI Adoption Review of one priority process",
  "Manage risk and bring the AI we already use under control",
  "Capability building for our leaders and teams",
  "Something else"];
var GETS = ["A 90-day, 6-month and 12-month roadmap",
  "A one-page summary for your leadership",
  "Your scores in every area, compared with your sector",
  "What’s blocking you — and what it costs you",
  "Your risk and compliance gaps, and the AI rules for your sector and country",
  "The training your people need to make the organisation AI-ready",
  "Your highest-value AI opportunities, ranked",
  "Which Cypher-One programmes fit your gaps"];
var BAND_PLAIN = { Exploring:"You’re at the start. AI is being talked about more than it is being used.",
  Experimenting:"You have real foundations, but the pieces aren’t yet working together. Pilots are happening; scale isn’t.",
  Scaling:"AI is working in parts of the business. The task now is to make it repeatable and governed.",
  Leading:"AI is part of how you operate. The task now is to protect and extend that lead." };
var BAND_SHORT = { Exploring:"Talking about AI; little in use.", Experimenting:"Pilots under way; not yet at scale.",
  Scaling:"AI working in parts of the business.", Leading:"AI built into how you operate." };

function toggleOpen(el){ el.classList.toggle("open"); var m=el.querySelector(".more"); if(m) m.textContent = el.classList.contains("open") ? (m.getAttribute("data-c")||"Close −") : m.getAttribute("data-o"); }
function setC(f,v){ S[f]=v; save(); }
function countryText(){ return S.country==="Other" ? (S.otherCountry||"Other") : (S.country||""); }

function snapshotHTML(){
  var R=compute(), d=R.d, bi=BANDS.indexOf(R.band);
  if(!S.cRole && S.role) S.cRole=S.role;
  if(!S.cSector && S.sectors.length) S.cSector=S.sectors[0];
  var meta=[sectorText(), countryText(), today()].filter(Boolean).join(" · ");
  var h='<div class="snap"><div class="snap-top"><button class="btn-ghost" onclick="reset()">↺ '+T().restart+'</button></div><div class="snapc">';

  /* 1. score */
  h+='<div class="blk"><div class="s-eyb">Your AI readiness snapshot</div><div class="s-meta">'+esc(meta)+'</div>'
    +'<div class="s-hero"><div>'+gauge(R.composite)+'</div><div><div class="s-band" style="color:'+R.band.color+'">'+R.band.label+'</div><p class="s-l">'+BAND_PLAIN[R.band.label]+'</p></div></div></div>';

  /* 2. journey */
  var lad=BANDS.map(function(x,i){ return '<div class="st'+(i===bi?' on':'')+(i===bi+1?' next':'')+'">'+(i===bi?'<span class="here">You are here</span>':'')+'<b>'+x.label+'</b>'+x.min+'–'+x.max+'<br>'+BAND_SHORT[x.label]+'</div>'; }).join('');
  var low=R.gaps.slice(0,3).map(function(g){ return '<b>'+g.label.toLowerCase()+'</b>'; });
  var jline = bi<BANDS.length-1 ? 'To reach <b>'+BANDS[bi+1].label+'</b>, your three lowest areas matter most: '+low[0]+', '+low[1]+' and '+low[2]+'.'
                                : 'You’re in the top stage. The task now is to protect and extend that lead.';
  h+='<div class="blk lg"><div class="s-sec">Your readiness journey</div><div class="lad">'+lad+'</div><p class="s-l" style="font-size:15.5px;margin-top:14px">'+jline+'</p></div>';

  /* 3. at a glance */
  var nStrong=DIMS.filter(function(x){ return d[x.key]>=60; }).length, nWeak=DIMS.filter(function(x){ return d[x.key]<40; }).length;
  var acts=R.roadmap.now.length+R.roadmap.six.length+R.roadmap.twelve.length;
  h+='<div class="blk"><div class="s-sec">At a glance</div><div class="tiles">'
    +'<div class="ti"><div class="n">'+nStrong+'<small> of 8</small></div><div class="l">areas where you’re already strong</div></div>'
    +'<div class="ti r"><div class="n">'+nWeak+'<small> of 8</small></div><div class="l">areas that need urgent attention</div></div>'
    +'<div class="ti"><div class="n">'+S.blockers.length+'</div><div class="l">blockers you told us are slowing you down</div></div>'
    +'<div class="ti r"><div class="n">'+acts+'</div><div class="l">actions identified in your roadmap</div></div></div></div>';

  /* 4. areas: first two clear, rest blurred under the full-report box */
  function arow(g){ var v=d[g.key]; return '<div class="ar"><span>'+g.label+'</span><div class="sbar"><i style="width:'+v+'%;background:'+(v<40?'#E8321A':'#1F1D1C')+'"></i></div><b style="text-align:right">'+v+'</b></div><div class="ad">'+g.desc+'</div>'; }
  var gl=GETS.map(function(g,i){ return '<div class="gi"><i>'+(i+1)+'</i><span>'+g+'</span></div>'; }).join('');
  h+='<div class="blk lg"><div class="s-sec">How you did in each area</div>'+DIMS.slice(0,2).map(arow).join('')
    +'<div class="areas"><div class="bz" aria-hidden="true">'+DIMS.slice(2).map(arow).join('')+'</div>'
    +'<div class="ov"><div class="ovh">🔒 What you get in the full report</div><div class="get">'+gl+'</div></div></div></div>';

  /* 5. contact form */
  h+='<div class="blk">'+(S.submitted ? thanksHTML() : formHTML())+'</div>';
  h+='</div></div>';
  return h;
}
function thanksHTML(){
  return '<div class="thanks"><h3 style="font-size:24px;font-weight:900;color:var(--ink)">Thank you'+(S.cName?', '+esc(S.cName.split(" ")[0]):'')+'.</h3>'
    +'<p style="font-size:15.5px;color:#3F3D3B;line-height:1.55;margin:0">We’ve emailed your personalised <b>AI Readiness Report (PDF)</b> to <b>'+esc(S.cEmail)+'</b>. A member of the Cypher-One team will be in touch shortly to set up your session.</p></div>';
}
function formHTML(){
  var rad=WANTS.map(function(o,i){ return '<label><input type="radio" name="want"'+(S.cWant===i?' checked':'')+' onchange="setC(\'cWant\','+i+')">'+o+'</label>'; }).join('');
  var opts='<option value="">Select the sector you operate in</option>'+SECTORS.map(function(s){ return '<option'+(S.cSector===s?' selected':'')+'>'+esc(s)+'</option>'; }).join('');
  return '<div class="frm"><h3>Let’s dive deeper.</h3><p class="lead">Tell us what would help most. We will email your full <b>AI Readiness Report (PDF)</b> and set up a session with our team.</p>'
    +'<div class="fq">What would you like from us?</div><div class="rad">'+rad+'</div>'
    +'<div class="fg">'
    +'<div><label class="fl" for="cName">Your name</label><input id="cName" type="text" value="'+esc(S.cName)+'" oninput="setC(\'cName\',this.value)"></div>'
    +'<div><label class="fl" for="cOrg">Organisation</label><input id="cOrg" type="text" value="'+esc(S.cOrg)+'" oninput="setC(\'cOrg\',this.value)"></div>'
    +'<div><label class="fl" for="cEmail">Work email</label><input id="cEmail" type="email" value="'+esc(S.cEmail)+'" oninput="setC(\'cEmail\',this.value)"></div>'
    +'<div><label class="fl" for="cRole">Role</label><input id="cRole" type="text" value="'+esc(S.cRole)+'" oninput="setC(\'cRole\',this.value)"></div>'
    +'<div class="full"><label class="fl" for="cSector">Sector</label><select id="cSector" onchange="setC(\'cSector\',this.value)">'+opts+'</select></div>'
    +'<div class="full"><label class="fl" for="cMsg">In your own words</label><textarea id="cMsg" placeholder="What is the problem, the idea, or the question you want answered?" oninput="setC(\'cMsg\',this.value)">'+esc(S.cMsg)+'</textarea></div>'
    +'</div>'
    +'<input type="text" id="cHp" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0">'
    +'<div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;margin-top:18px"><button id="sendBtn" class="sbtn" onclick="sendSnapshot()">Send &amp; receive report (PDF)</button>'
    +'<span class="pe">Prefer email? <a href="mailto:'+c1aEmail()+'">'+c1aEmail()+'</a></span></div>'
    +(S.sendErr?'<div class="ferr">'+esc(S.sendErr)+'</div>':'')+'</div>';
}

function fmtDate(){ return new Date().toLocaleString("en-GB",{day:"numeric",month:"long",year:"numeric",hour:"2-digit",minute:"2-digit"}); }
function ansLabel(q){
  if(S.unsure[q.id]) return "Not sure";
  var a=S.answers[q.id]; if(a===undefined||a===null) return "Not answered";
  var t=q.opts[a]; if(q.type==="knowledge") t+=(a===q.correct?"  [correct]":"  [incorrect — correct: "+q.opts[q.correct]+"]");
  return t;
}
function fullReportText(R){
  var L=[];
  L.push("CYPHER-ONE AI READINESS — FULL RESULTS (internal)");
  L.push("Submitted: "+fmtDate()+"  ·  Assessment ID: "+AID+"  ·  "+VERSION);
  L.push(""); L.push("REQUEST");
  L.push("Wants: "+(WANTS[S.cWant]||"Not chosen"));
  L.push("Name: "+S.cName); L.push("Work email: "+S.cEmail); L.push("Organisation: "+(S.cOrg||"Not given"));
  L.push("Role: "+(S.cRole||"Not given")); L.push("Sector (form): "+(S.cSector||"Not given"));
  L.push("In their own words: "+(S.cMsg||"—"));
  L.push(""); L.push("PROFILE");
  L.push("Country: "+(countryText()||"Not given")); L.push("Organisation size: "+(S.size||"Not given")); L.push("Role (profile): "+(S.role||"Not given"));
  L.push("Sectors: "+sectorText()); L.push("AI usage: "+(S.usage||"Not given")); L.push("Types of AI: "+(S.aiTypes.join(", ")||"None selected"));
  L.push("Self-assessed risk level: "+(S.riskClass||"Not given")); L.push("Risk process: "+(S.riskProcess||"Not given"));
  L.push(""); L.push("SCORES");
  L.push("Overall readiness: "+R.composite+"/100 — "+R.band.label);
  R.pillars.forEach(function(p){ L.push("Pillar "+p.n+" · "+p.name+": "+p.value); });
  DIMS.forEach(function(x){ L.push("  "+x.label+": "+R.d[x.key]); });
  L.push("Knowledge check: "+R.know+"   ·   Why it matters: "+R.why);
  L.push("Weakest pillar: "+R.weakPillar.name+" — suggested: "+R.weakPillar.cta);
  L.push(""); L.push("BLOCKERS NAMED: "+(S.blockers.length?S.blockers.join("; "):"None"));
  L.push(""); L.push("ROADMAP");
  [["Next 90 days",R.roadmap.now],["Next 6 months",R.roadmap.six],["Next 12 months",R.roadmap.twelve]].forEach(function(b){
    L.push(b[0]+":"); b[1].forEach(function(x){ L.push("  - "+x.t+" ("+x.s+") — "+x.d); }); });
  L.push(""); L.push("ALL ANSWERS");
  var sec={practice:"Your practice",know:"What good looks like",why:"Why it matters"};
  STEPS.forEach(function(q,n){ if(q.section==="gate"||!sec[q.section]) return; L.push((n+1)+". ["+sec[q.section]+"] "+q.text); L.push("   → "+ansLabel(q)); });
  return L.join("\n");
}
function sendSnapshot(){
  var ok = S.cName.trim() && /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(S.cEmail.trim());
  if(!ok){ S.sendErr="Please add your name and a valid work email."; save(); render(); return; }
  var viaWP = !!ENDPOINT;
  if(!viaWP && (!WEB3FORMS_KEY || WEB3FORMS_KEY.indexOf("PASTE-")===0)){ S.sendErr="Sending isn’t set up yet. Please email us at "+(C1A.email||"contact@cypher-one.ai")+"."; save(); render(); return; }
  var R=compute(), btn=document.getElementById("sendBtn"); if(btn){ btn.disabled=true; btn.textContent="Sending…"; }
  var payload={ access_key:(viaWP?undefined:WEB3FORMS_KEY), assessment_id:AID, website:(document.getElementById("cHp")||{}).value||"",
    subject:"AI Readiness request — "+(S.cOrg||S.cName)+" — "+R.composite+"/100 ("+R.band.label+")",
    from_name:"Cypher-One AI Readiness", name:S.cName, email:S.cEmail, organisation:S.cOrg||"Not given", role:S.cRole||"Not given",
    sector:S.cSector||"Not given", wants:WANTS[S.cWant]||"Not chosen", message:S.cMsg||"—",
    overall_score:R.composite+"/100 — "+R.band.label, full_report:fullReportText(R),
    data_json:JSON.stringify({ app:"c1-ai-readiness", version:VERSION, aid:AID, submitted:new Date().toISOString(), state:S }) };
  fetch(viaWP ? ENDPOINT+"/request" : "https://api.web3forms.com/submit",{ method:"POST", credentials:"omit", headers:{"Content-Type":"application/json","Accept":"application/json"}, body:JSON.stringify(payload) })
    .then(function(r){ return r.json().then(function(j){ return { ok:r.ok && j.success!==false, j:j }; }); })
    .then(function(x){ if(x.ok){ S.submitted=true; S.sendErr=""; } else { S.sendErr="We couldn’t send your request ("+((x.j&&x.j.message)||"unknown error")+"). Please try again, or email "+(C1A.email||"contact@cypher-one.ai")+"."; } save(); render(); })
    .catch(function(){ S.sendErr="We couldn’t reach the server. Please check your connection and try again."; save(); render(); });
}


/* ============================ report ============================ */
function ctaHTML(R,inReport){
  var h = '<div class="card no-print" style="background:var(--navy);border-color:var(--navy);padding:28px;margin-top:18px">'
    + '<div class="g2" style="align-items:center"><div>'
    + '<div class="eyebrow" style="color:var(--accent-hi)">Your weakest pillar · '+R.weakPillar.name+'</div>'
    + '<h3 style="font-size:24px;font-weight:800;color:#fff;margin:12px 0 8px;line-height:1.28">Turn this into a plan your board can fund.</h3>'
    + '<p style="font-size:15.5px;color:#B8B4B1;line-height:1.55;margin:0 0 12px">Where you scored lowest, we would start with: <b style="color:#fff">'+R.weakPillar.cta+'</b></p>';
  h += '</div><div>';
  if(S.submitted){
    h += '<div style="background:#2A2827;border-radius:0;padding:22px;color:#E6E3E0;text-align:center">'
      + '<div style="font-size:16.5px;font-weight:700;color:#fff;margin:0 0 4px">Thank you</div>'
      + '<div style="font-size:14.5px;color:#B8B4B1">In the full product this books a Cypher-One diagnostic and saves your result to the benchmark.</div></div>';
  } else {
    h += '<label style="font-family:var(--mono);font-size:11px;font-weight:700;letter-spacing:1.2px;color:#9A9693;text-transform:none">Work email for a full review</label>'
      + '<input type="email" id="emailIn" placeholder="name@institution.qa" style="margin-top:9px;background:#161514;border:1px solid #4A4745;color:#fff" value="'+esc(S.email)+'" oninput="setText(\'email\',this.value)">'
      + '<div id="emailErr" style="color:var(--red);font-size:12.5px;margin-top:6px;display:none">Please enter a valid work email.</div>'
      + '<button class="btn-brass arrow" style="width:100%;justify-content:center;margin-top:10px" onclick="submitEmail()">Book a full review </button>'
      + (ENDPOINT ? '' : '<div style="font-size:12px;color:#9A9693;margin-top:10px;text-align:center">Demo — no email is sent.</div>');
  }
  h += '</div></div></div>';
  return h;
}
function submitEmail(){
  if(!S.email || S.email.indexOf("@")<0){ var e=document.getElementById("emailErr"); if(e) e.style.display="block"; return; }
  S.submitted=true; save(); post("/leads",{ assessment_id:AID, email:S.email, wants_report:true, data_json:JSON.stringify({ app:"c1-ai-readiness", version:VERSION, aid:AID, submitted:new Date().toISOString(), state:S }) }); render();
}

/* ============================ report ============================ */
var ENDPOINT = C1A.endpoint || "";
function post(path,body){ if(!ENDPOINT) return;
  try{ fetch(ENDPOINT+path,{method:"POST",credentials:"omit",headers:{"Content-Type":"application/json"},body:JSON.stringify(body),keepalive:true}).catch(function(){}); }catch(e){} }


/* How the respondent actually did in each part — appended to the generic explanation. */
function verdict(section,v){
  var i = v>=70 ? 0 : (v>=40 ? 1 : 2);
  var M = {
    "Section 1: Your practice":[
      "your day-to-day practice is largely sound, and the work now is to keep it consistent and evidenced as your AI estate grows.",
      "the foundations exist but coverage is uneven, and it is the uneven areas where initiatives quietly stall.",
      "the operating conditions AI depends on are not yet in place, which is where remediation needs to start."],
    "Section 2: What good looks like":[
      "you are well informed about what strong adoption actually requires here, which is what allows you to challenge vendor claims and set realistic expectations internally.",
      "you know part of the picture, and the gaps are usually where investment gets misdirected.",
      "the regional evidence is largely unknown to you today, and decisions taken without it typically cost more to unwind than they would have cost to get right."],
    "Section 3: Why it matters":[
      "leadership clearly understands why AI behaves differently from ordinary software, which is the mindset that gets governance and capability funded early.",
      "the awareness is there but uneven, and the underestimated risks are usually where the first surprise comes from.",
      "the stakes are not yet fully recognised, which is the most exposed position to be in: the risk exists before anyone is watching for it."]
  };
  return "You scored "+v+" here \u2014 "+(M[section]?M[section][i]:"");
}

var REPORT_TOC = ["Executive summary","Your score, visualised","The four pillars","How you did in each part",
  "Your score in every area","Fix these first","Your roadmap","Recommended actions","What's stalling you",
  "What this is costing you","The frameworks you're judged against","Your AI profile","How this was worked out"];
function psec(t){ return '<h2 class="psec">'+t+'</h2>'; }
function pb(){ return '<div class="pagebreak"></div>'; }
function tocHTML(R){
  var h='<section class="toc print-only">'
    + '<h2 style="font-size:22px;font-weight:900;color:var(--navy);margin:0 0 4px;letter-spacing:-.5px">Contents</h2>'
    + '<div style="font-size:12px;color:var(--mute);margin:0 0 14px">AI Readiness Report \u00b7 '+today()+'</div>';
  REPORT_TOC.forEach(function(t,i){
    h += '<div class="toc-row"><span class="toc-n">'+String(i+1).padStart(2,"0")+'</span><span class="toc-t">'+t+'</span></div>';
  });
  h += '<div style="margin-top:22px;border-top:2px solid var(--navy);padding-top:14px">'
    + '<div class="rlab" style="margin-bottom:10px">At a glance</div><div class="rgrid4">'
    + [["Readiness score",R.composite+"/100",R.band.color],["Band",R.band.label,R.band.color],
       ["Weakest pillar",R.weakPillar.name,"#1F1D1C"],["Blockers named",String(S.blockers.length),S.blockers.length?"#E8321A":"#2C6E5B"]]
      .map(function(x){ return '<div class="rcard" style="padding:10px 12px"><div style="font-family:var(--mono);font-size:9.5px;color:var(--mute);margin-bottom:4px">'+x[0]+'</div>'
        + '<div style="font-size:14px;font-weight:800;color:'+x[2]+';line-height:1.25">'+x[1]+'</div></div>'; }).join("")
    + '</div></div>';
  h += '<div style="margin-top:16px;border-left:4px solid var(--brass);background:#F7F7F7;padding:12px 16px">'
    + '<div class="rlab">About this report</div>'
    + '<div style="font-size:11.5px;color:var(--ink);line-height:1.55">A readiness assessment of how prepared this organisation is to adopt AI, scored across eight areas and weighted for the sectors it operates in. Prepared by Cypher-One. Not certification or legal advice.</div></div>'
    + '</section>';
  return h;
}
function bullets(list){ return list.map(function(x){ return '<div class="bullet">'+x+'</div>'; }).join(""); }

/* ---------- generated content ---------- */
function actionList(R){
  var d=R.d, out=[];
  S.blockers.forEach(function(b){
    var row=BLOCKERS.filter(function(x){ return x[0]===b; })[0];
    out.push({ t:"Unblock \u2014 "+row[0], d:"You told us this is stalling you. "+FIX[row[2]] });
  });
  if(S.riskClass==="High-Risk AI")
    out.push({ t:"High-risk AI requires full controls", d:"Risk management, human oversight, logging, accuracy testing and technical documentation, in place before deployment rather than after." });
  if(S.riskProcess==="No" || S.riskProcess==="Not sure")
    out.push({ t:"Establish AI risk management", d:"Readiness cannot be evidenced without it, and it is a prerequisite for high-risk AI under the EU AI Act." });
  if(d.strategy<70) out.push({ t:"Establish ownership and a funded plan", d:"AI needs a single accountable executive and a plan tied to business objectives. Where ownership is distributed, initiatives stall between functions rather than failing outright." });
  if(d.data<70)     out.push({ t:"Establish the data foundations", d:"Only 16% of GCC CEOs say their AI tools can reach the data they need. Access, quality and ownership take the longest to put right, so this work has to start early." });
  if(d.people<70)   out.push({ t:"Build capability by role", d:"A frontline user, an analyst and a board member require materially different capability. Undifferentiated training absorbs budget without changing how work is done." });
  if(d.value<70)    out.push({ t:"Put a value framework in place", d:"Prioritisation criteria, baselines set before deployment, and reporting the board can act on. Without it the programme cannot be defended at the next budget review." });
  if(d.leadership<70) out.push({ t:"Raise board-level understanding", d:"Board comprehension sets the ceiling on what an organisation can attempt, and determines whether funding covers scaling or stops at AI pilots." });
  if(d.technology<70) out.push({ t:"Consolidate onto a shared platform", d:"Where teams procure separately, cost duplicates and nothing carries forward. A shared foundation is what makes each initiative cheaper than the last." });
  if(d.process<70)  out.push({ t:"Redesign the work around AI", d:"Automating a single step while the surrounding process is unchanged delivers no measurable saving. The workflow and the change management have to move together." });
  if(d.trust<70)    out.push({ t:"Establish the governance basics", d:"An AI use policy, controlled tooling and a maintained register of AI in use. These are the minimum an auditor, partner or regulator will expect to see." });
  if(preAdoption()) out.push({ t:"Start narrow and prove it", d:"A small number of use cases selected on value and effort, delivered end to end and measured. Breadth before depth is the most common way early AI programmes stall." });
  return out.slice(0,8);
}

function exposure(R){
  var d=R.d, val=[], comp=[];
  if(R.composite<61) val.push("AI spend that never reaches daily use — the most common outcome for organisations at this level of readiness.");
  if(d.value<60)  val.push("No baseline, so no way to prove or defend the return on AI investment at the next budget review.");
  if(d.data<60)   val.push("Projects delayed or abandoned because the data could not be reached in time.");
  if(d.people<60) val.push("Licences and tools paid for but barely used, because staff were never trained for their actual role.");
  if(d.process<60)val.push("Automation that saves no time, because the workflow around it was left unchanged.");
  if(!val.length) val.push("No major value leakage flagged from your answers.");

  if(R.composite<61) comp.push("Falling behind regional peers — 70% of Middle East CEOs already have a defined AI roadmap.");
  if(d.trust<60)      comp.push("Governance gaps that surface in tender, procurement and partner due-diligence questionnaires.");
  if(d.technology<60) comp.push("Duplicated spend across teams buying separate tools for the same job.");
  if(d.leadership<60) comp.push("AI decisions made on vendor claims rather than internal understanding.");
  if(S.blockers.length) comp.push("Named blockers that will stall the next initiative exactly as they stalled the last one.");
  if(!comp.length)    comp.push("Well positioned against peers — the risk now is losing ground by standing still.");
  return { value:val, comp:comp };
}

/* ---------- the report ---------- */
function reportHTML(){
  var R = compute();
  if(!SENT){ SENT=true; post("/results",{ assessment_id:AID, submitted_at:new Date().toISOString(),
    rubric_version:VERSION, aligned_as_of:ALIGNED, country:S.country, size_band:S.size, role:S.role,
    sectors:S.sectors, composite:R.composite, knowledge:R.know, why:R.why, domains:R.d,
    pillars:R.pillars.map(function(p){ return {n:p.n,v:p.value}; }), band:R.band.label,
    risk_class:S.riskClass, risk_process:S.riskProcess, blockers:S.blockers, ai_usage:S.usage, ai_types:S.aiTypes }); }

  var acts = actionList(R), exp = exposure(R);
  var h = '<div class="wrap mid" style="padding-bottom:72px">';

  h += '<div class="no-print" style="display:flex;justify-content:space-between;align-items:center;padding:24px 0 14px">'
    + '<button class="btn-ghost" onclick="reset()">↺ '+T().restart+'</button>'
    + '<button class="btn-navy" onclick="window.print()">⎙ '+T().print+'</button></div>';

  /* ---- print cover ---- */
  h += '<section class="cover print-only"><div class="cover-in">'
    + '<div class="cover-top">'
      + '<span style="font-weight:900;font-size:21px;color:var(--navy);letter-spacing:-.8px;white-space:nowrap">cypher<span style="color:var(--red)">\u2022</span>one <span style="color:var(--brass)">AI Readiness</span></span>'
      + '<span style="font-family:var(--mono);font-size:10.5px;letter-spacing:1px;color:var(--mute)">Confidential</span></div>'
    + '<div class="cover-mid">'
      + '<div style="width:64px;height:4px;background:var(--brass);margin-bottom:24px"></div>'
      + '<div style="font-family:var(--mono);font-size:12.5px;letter-spacing:2.5px;color:var(--brass);margin-bottom:16px">Board report</div>'
      + '<h1 style="font-size:52px;font-weight:900;margin:0 0 22px;line-height:1.03;color:var(--navy);letter-spacing:-1.6px">AI Readiness<br>Report</h1>'
      + '<div style="font-size:16.5px;color:var(--steel);line-height:1.5">Prepared for an organisation in<br><b style="color:var(--navy)">'+esc(sectorText())+'</b></div>'
      + '<div style="font-family:var(--mono);font-size:11.5px;color:var(--mute);margin-top:14px;letter-spacing:.3px">'+today()+' \u00b7 '+VERSION+' \u00b7 aligned '+ALIGNED+'</div>'
    + '</div>'
    + '<div class="cover-rule"></div>'
    + '<div class="cover-base">'
      + '<div><div style="font-size:13.5px;color:var(--navy);font-weight:600;margin-bottom:3px">'+TAGLINE+'</div>'
      + '<div style="font-family:var(--mono);font-size:10px;color:var(--mute);letter-spacing:.3px">Prepared by Cypher-One \u00b7 '+c1aLoc()+'</div></div>'
      + '<div style="font-family:var(--mono);font-size:10px;color:var(--mute);letter-spacing:.3px;text-align:right;line-height:1.7">'
      + c1aEmail()+'<br>'+c1aWeb()+'</div>'
    + '</div></div></section>';

  h += '<div class="runfoot print-only"><span>Cypher\u2022One \u00b7 AI Readiness Report \u00b7 Confidential \u00b7 '+today()+'</span></div>';
  h += tocHTML(R);

  h += '<div class="card report" style="padding:36px">';

  /* ---- masthead (screen) ---- */
  h += '<div class="no-print" style="border-bottom:3px solid var(--navy);padding-bottom:16px;margin-bottom:6px">'
    + '<div style="display:flex;justify-content:space-between;align-items:baseline;flex-wrap:wrap;gap:8px">'
    + '<span style="font-weight:900;font-size:20px;color:var(--navy);letter-spacing:-.8px">cypher<span style="color:var(--red)">•</span>one <span style="color:var(--brass)">AI Readiness</span></span>'
    + '<span style="font-family:var(--mono);font-size:11px;font-weight:700;color:var(--ink);letter-spacing:.5px">'+VERSION+' · Aligned '+ALIGNED+'</span></div>'
    + '<h1 style="font-size:30px;font-weight:900;color:var(--navy);margin:14px 0 4px;letter-spacing:-.8px">AI Readiness Report</h1>'
    + '<div style="font-size:14.5px;color:var(--ink);font-weight:500">Sectors: <b>'+esc(sectorText())+'</b> · '+today()+' · Confidential</div></div>';

  /* ---- 1. Executive summary ---- */
  var plain = {
    Leading:"Your organisation scored "+R.composite+" out of 100 — a strong result. You are set up to adopt AI properly: the plan, the people, the data and the platform are largely in place. The task now is to protect that position, bring every new AI tool inside the same controls, and turn readiness into measured value.",
    Scaling:"Your organisation scored "+R.composite+" out of 100. You have real foundations and are past the experiment stage, but a few specific areas are holding you back from scaling cleanly. Close the gaps below and AI moves from working in places to working across the organisation.",
    Experimenting:"Your organisation scored "+R.composite+" out of 100. AI is being tried, but the conditions for it to succeed are not yet in place — which is exactly how AI pilots stall. The fixes are known, sequenced below, and mostly organisational rather than technical.",
    Exploring:"Your organisation scored "+R.composite+" out of 100 — a low result that should be taken seriously. Adopting AI in this state risks spending money on tools that never reach daily use. Start with ownership, data access and a small number of well-chosen use cases, and treat this as a board-level priority."
  };
  var across = {
    Leading:"Across the eight areas of readiness, coverage is strong and consistent. That is a mature position few organisations in the region have reached. Keep the evidence current, re-run this check as your AI estate grows, and the advantage compounds.",
    Scaling:"Across the eight areas of readiness the core is solid, but the weakest areas are the ones that decide whether an AI pilot becomes a system. They are named below, in the order that lifts your score fastest.",
    Experimenting:"Across the eight areas of readiness the coverage is uneven — some are handled well while others are effectively unmanaged. That inconsistency is itself the risk: it is the unmanaged areas where AI pilots quietly stall, spend goes unmeasured, and the organisation concludes that AI does not work for them.",
    Exploring:"Across the eight areas of readiness, the basics are largely missing. Ambition is not the constraint here — 82% of Middle East CEOs say their culture enables AI adoption. Execution is. Without ownership, data access and a way to measure value, further AI spend is unlikely to return anything."
  };
  h += psec("Executive summary")
    + '<div class="keep" style="border-left:5px solid '+R.band.color+';background:#F7F7F7;border-radius:0;padding:16px 20px;margin-bottom:12px">'
    + '<div class="rlab">In plain terms</div>'
    + '<p style="font-size:15.5px;line-height:1.6;color:#111;margin:0;font-weight:500">'+plain[R.band.label]+'</p></div>'
    + '<p class="keep" style="font-size:13.5px;line-height:1.6;color:var(--ink);margin:0">'+across[R.band.label]+'</p>';

  if(preAdoption())
    h += '<div class="keep" style="border:1px solid var(--brass);background:#F7F2F0;border-radius:0;padding:11px 15px;margin-top:12px;font-size:13px;color:#8A1A0C;font-weight:600">Assessed as pre-adoption readiness — scores reflect preparedness rather than current practice.</div>';

  /* ---- 2. Score, visualised ---- */
  h += psec("Your score, visualised")
    + '<div class="rgrid2">'
    + '<div class="keep rcard" style="padding:14px 12px"><div class="rlab" style="text-align:center">Overall score</div>'
    + gauge(R.composite)
    + '<div style="display:flex;flex-wrap:wrap;gap:5px 12px;justify-content:center;margin-top:6px">'
    + BANDS.map(function(b){ return '<span style="display:inline-flex;align-items:center;gap:5px;font-size:11px;color:var(--ink);font-weight:600"><span style="width:10px;height:10px;border-radius:0;background:'+b.color+'"></span>'+b.label+'</span>'; }).join("")
    + '</div></div>'
    + '<div class="keep rcard" style="padding:14px 12px"><div class="rlab" style="text-align:center">Readiness profile · all 8 areas</div>'
    + radar(R.d,272)
    + '<div style="font-size:11px;color:var(--mute);text-align:center;margin-top:4px">Solid = you · dashed = illustrative sector median</div></div></div>';

  /* ---- 4. Four pillars ---- */
  h += '<section class="tight">';
  h += psec("The four pillars")
    + '<p class="keep lead" style="font-size:13px;color:var(--ink);line-height:1.55;margin:0 0 10px">Your eight areas roll into the four dimensions every organisation must address to adopt AI successfully.</p>'
    + '<div class="rgrid4">';
  R.pillars.forEach(function(p){
    var b=band(p.value), weak=(p.n===R.weakPillar.n);
    h += '<div class="keep rcard" style="border-top:3px solid '+b.color+'">'
      + '<div style="font-family:var(--mono);font-size:10.5px;font-weight:700;color:var(--mute)">Pillar '+p.n+(weak?" · weakest":"")+'</div>'
      + '<div style="font-family:var(--mono);font-size:26px;font-weight:800;color:'+b.color+';line-height:1.15;margin:3px 0 1px">'+p.value+'<span style="font-size:12px;color:var(--mute)">/100</span></div>'
      + '<b style="font-size:13px;color:var(--navy);line-height:1.3;display:block">'+p.name+'</b>'
      + '<div style="font-size:11px;color:var(--mute);margin-top:3px">'+p.dims.map(function(k){ return DIMS.filter(function(dd){return dd.key===k;})[0].label; }).join(" · ")+'</div></div>';
  });
  h += '</div>';

  h += '</section>';
  /* ---- 5. Each part ---- */
  h += psec("How you did in each part") + '<div style="display:grid;gap:14px">';
  [["Section 1: Your practice",R.composite,"How well you actually run and control AI day to day — who owns it, whether people are trained for it, whether it can reach your data, and whether anyone measures what it returns. Built from your answers across all eight areas and weighted for your sector."],
   ["Section 2: What good looks like",R.know,"How well you know what strong AI adoption looks like in this region. Many organisations score low here simply because the regional evidence is not widely known — including that data access, not ambition, is the Gulf's binding constraint."],
   ["Section 3: Why it matters",R.why,"Whether your organisation recognises what makes AI different from ordinary software: that it reaches production only with ownership, data and workflow change behind it, and that an unmeasured programme is the first thing cut."]
  ].forEach(function(x){
    h += '<div class="keep"><div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:5px">'
      + '<b style="font-size:15px;color:var(--navy)">'+x[0]+'</b>'
      + '<b style="font-family:var(--mono);font-size:14px;color:'+band(x[1]).color+'">'+x[1]+'/100 · '+band(x[1]).label+'</b></div>'
      + barHTML(x[1],false)
      + '<div style="font-size:12.5px;color:var(--ink);line-height:1.55;margin-top:6px">'+x[2]
      + ' <b style="color:var(--navy)">'+verdict(x[0],x[1])+'</b></div></div>';
  });
  h += '</div>';

  /* ---- 6. Every area ---- */
  h += psec("Your score in every area")
    + '<p class="keep lead" style="font-size:13px;color:var(--ink);line-height:1.55;margin:0 0 10px">Your eight areas of readiness, weakest first. The radar above plots the same figures. The marker on each bar is the illustrative median for your sector — the fixes overleaf target the lowest of these.</p>'
    + '<div class="rgrid2">';
  R.gaps.forEach(function(dim){
    var v=R.d[dim.key];
    h += '<div class="keep rcard" style="padding:10px 13px">'
      + '<div style="display:flex;justify-content:space-between;align-items:baseline">'
      + '<b style="font-size:13.5px;color:var(--navy)">'+dim.label+'</b>'
      + '<b style="font-family:var(--mono);font-size:13px;color:'+band(v).color+'">'+v+'/100</b></div>'
      + barHTML(v,true,BENCH[dim.key])
      + '<div style="font-size:11.5px;color:var(--steel);line-height:1.45;margin-top:4px">'+dim.desc+'</div></div>';
  });
  h += '</div>';

  /* ---- 7. Fix these first ---- */
  h += '<section class="tight">';
  h += psec("Fix these first")
    + '<p class="keep lead" style="font-size:13px;color:var(--ink);line-height:1.55;margin:0 0 10px">Your three weakest areas. Closing these lifts your score fastest. These are programme-level changes rather than tasks, and most organisations need external support to scope and sequence them.</p>'
    + '<div class="rgrid3">';
  R.gaps.slice(0,3).forEach(function(dim){
    var v=R.d[dim.key];
    h += '<div class="keep rcard" style="border-top:3px solid '+band(v).color+'">'
      + '<div style="font-family:var(--mono);font-size:19px;font-weight:900;color:'+band(v).color+'">'+v+'<span style="font-size:11px;color:var(--mute)">/100</span></div>'
      + '<b style="font-size:13.5px;color:var(--navy);display:block;margin:2px 0 4px">'+dim.label+'</b>'
      + '<div style="font-size:11.5px;color:var(--steel);line-height:1.5">'+FIX[dim.key]+'</div></div>';
  });
  h += '</div>';

  h += '</section>';
  /* ---- 8. Roadmap ---- */
  h += psec("Your roadmap")
    + '<p class="keep lead" style="font-size:13px;color:var(--ink);line-height:1.55;margin:0 0 12px">Built from your lowest scores and the blockers you named, and sequenced so the organisational foundations land first while the long-lead work starts early enough to matter. The sequence matters as much as the content: work taken out of order is the most common reason readiness programmes overrun.</p>';
  
  [["Next 90 days","Stabilise",R.roadmap.now],["Next 6 months","Build",R.roadmap.six],["Next 12 months","Scale",R.roadmap.twelve]].forEach(function(g){
    h += '<div class="road-band keep"><div class="road-when"><b>'+g[0]+'</b><span>'+g[1]+'</span></div><div class="rgrid3">';
    g[2].forEach(function(it){
      h += '<div class="rcard" style="padding:9px 12px">'
        + '<div style="display:flex;align-items:center;gap:7px;margin-bottom:3px">'
        + '<span class="road-score" style="background:'+band(it.s).color+';font-size:10.5px;min-width:26px;padding:2px 4px">'+it.s+'</span>'
        + '<b style="font-size:12.5px;color:var(--navy)">'+it.t+'</b></div>'
        + '<div style="font-size:11.5px;color:var(--ink);line-height:1.45">'+it.d+'</div></div>';
    });
    h += '</div></div>';
  });

  /* ---- 9. Recommended actions ---- */
  h += psec("Recommended actions") + '<div class="rgrid2">';
  acts.forEach(function(a){
    h += '<div class="keep act"><b style="font-size:12.5px;color:var(--navy)">'+a.t+'</b>'
      + '<div style="font-size:11.5px;color:var(--ink);line-height:1.45;margin-top:2px">'+a.d+'</div></div>';
  });
  h += '</div>';

  /* ---- 10. Blockers ---- */
  h += psec("What's stalling you")
    + '<p class="keep lead" style="font-size:13px;color:var(--ink);line-height:1.6;margin:0 0 10px">Alongside the scores, you were asked to name what is actually holding AI back. These are not scored \u2014 they are the practical constraints that determine whether the roadmap above can be delivered at all, and they are usually the difference between a programme that moves and one that does not.</p>'
    + '<div class="keep" style="border-left:5px solid '+(S.blockers.length?"var(--red)":"var(--green)")+';background:'+(S.blockers.length?"var(--redbg)":"#EAF5EF")+';border-radius:0;padding:12px 16px;margin-bottom:14px">'
    + '<div class="rlab" style="color:'+(S.blockers.length?"var(--red)":"var(--green)")+'">What this tells us</div>'
    + '<div style="font-size:12.5px;color:var(--ink);line-height:1.6">'+blockerNarrative(R)+'</div></div>';

  if(S.blockers.length){
    h += '<div style="margin-bottom:14px">';
    S.blockers.forEach(function(bname,i){
      var row=BLOCKERS.filter(function(x){ return x[0]===bname; })[0];
      var dim=DIMS.filter(function(d){ return d.key===row[2]; })[0], sc=R.d[row[2]];
      h += '<div class="keep" style="border:1px solid #F0B7AF;border-left:4px solid var(--red);border-radius:0;padding:11px 14px;margin-bottom:8px">'
        + '<div style="display:flex;justify-content:space-between;align-items:baseline;gap:10px;margin-bottom:4px">'
        + '<b style="font-size:13.5px;color:var(--navy)">'+(i+1)+'. '+row[0]+'</b>'
        + '<span style="font-family:var(--mono);font-size:10px;color:var(--mute)">Shows up in '+dim.label+' \u00b7 <b style="color:'+band(sc).color+'">'+sc+'/100</b></span></div>'
        + '<div style="font-size:12px;color:var(--steel);line-height:1.5;margin-bottom:5px">'+row[1]+'</div>'
        + '<div style="font-size:12px;color:var(--ink);line-height:1.55"><b style="color:var(--navy)">Why it stalls things.</b> '+(BLOCKER_WHY[row[0]]||"")+'</div>'
        + '<div style="font-size:11.5px;color:var(--ink);line-height:1.5;margin-top:5px;padding-top:5px;border-top:1px dotted var(--line)">'
        + '<b style="color:var(--navy)">What clears it.</b> '+FIX[row[2]]+'</div></div>';
    });
    h += '</div>';
  }

  h += '<div class="keep"><div class="rlab" style="margin-bottom:6px">The full set</div><div style="display:grid;gap:4px">';
  BLOCKERS.forEach(function(b){
    var on=S.blockers.indexOf(b[0])>=0;
    h += '<div style="display:flex;gap:10px;align-items:flex-start;font-size:11.5px;color:var(--ink);line-height:1.45;background:'+(on?"var(--redbg)":"#F4F8F5")+';border-radius:0;padding:6px 10px;break-inside:avoid">'
      + '<span class="chip-stat" style="background:'+(on?"var(--red)":"#3BA776")+'">'+(on?"Blocking you":"Not selected")+'</span>'
      + '<span><b style="color:var(--navy)">'+b[0]+'.</b> '+b[1]+'</span></div>';
  });
  h += '</div></div>';
  h += '<p class="keep" style="font-size:12.5px;color:var(--ink);line-height:1.6;margin:12px 0 0">None of these are technology problems. Every one is a question of ownership, structure, access or measurement \u2014 which is precisely why they persist inside organisations that have already bought capable tools. They are also the reason readiness work is difficult to do from the inside: the constraints usually sit across functions, and clearing them requires a mandate that no single function holds.</p>';

  /* ---- 11. Exposure ---- */
  h += '<section class="tight">';
  h += psec("What this is costing you") + '<div class="rgrid2">'
    + '<div class="keep rcard"><div class="rlab" style="color:var(--red)">Value at risk</div>'+bullets(exp.value)+'</div>'
    + '<div class="keep rcard"><div class="rlab" style="color:var(--brass)">Competitive position</div>'+bullets(exp.comp)+'</div></div>';

  h += '</section>';
  /* ---- 12. Frameworks ---- */
  h += '<section class="tight">';
  h += psec("The frameworks you're judged against")
    + '<p class="keep lead" style="font-size:13px;color:var(--ink);line-height:1.55;margin:0 0 10px">Readiness is not only an internal question. These are the reference points your board, your regulator and your partners will use.</p>'
    + '<div class="rgrid2">';
  ANCHORS.forEach(function(a){
    h += '<div class="keep rcard" style="border-left:4px solid '+a[1]+'">'
      + '<b style="font-family:var(--mono);font-size:12px;color:'+a[1]+'">'+a[0]+'</b>'
      + '<div style="font-size:11.5px;color:var(--ink);line-height:1.45;margin-top:3px"><b style="color:var(--navy)">'+a[3]+'</b> '+a[2]+'</div></div>';
  });
  h += '</div>';

  h += '</section>';
  /* ---- 13. Profile ---- */
  h += '<section class="tight">';
  h += psec("Your AI profile") + '<table class="tbl keep"><tbody>';
  [["Country",(S.country==="Other"&&S.otherCountry)?S.otherCountry:(S.country||"Not specified")],
   ["Organisation size",S.size||"Not specified"],["Role",S.role||"Not specified"],
   ["AI usage",S.usage||"Not specified"],["Types of AI used",S.aiTypes.length?S.aiTypes.join(", "):"Not specified"],
   ["Self-assessed risk level",S.riskClass||"Not specified"],["AI strategy",S.riskProcess||"Not specified"],
   ["Sectors of operation",sectorText()]
  ].forEach(function(r){ h += '<tr><td class="k">'+r[0]+'</td><td>'+esc(r[1])+'</td></tr>'; });
  h += '</tbody></table>';

  h += '</section>';
  /* ---- 14. Method ---- */
  h += '<section class="tight">';
  h += psec("How this was worked out")
    + '<p class="keep" style="font-size:11.5px;color:var(--steel);line-height:1.6;margin:0">'+TITLE+' scores eight areas of AI readiness from a short self-assessment, weighted by the sectors you operate in, plus checks of how well you know what strong adoption looks like and why AI needs readiness at all. The eight areas roll into the Cypher-One four-pillar model: capability, governance and value assurance, transformation and strategy, and platforms. Questions and benchmarks draw on PwC\'s 29th Global CEO Survey (Middle East findings, January 2026), the MCIT National AI Policy consultation, the GCC AI Regulation Playbook (July 2026), Qatar National Vision 2030, Digital Agenda 2030 and ISO/IEC 42001. Cautionary cases are real, publicly reported projects summarised from primary filings and tier-one reporting. Rubric '+VERSION+', aligned to '+ALIGNED+'; sector weights and all benchmark medians are illustrative and pending validation. This is a <b>readiness</b> check, not certification or legal advice. Prepared by Cypher-One.</p>';

  /* ---- 15. Contact ---- */
  h += '<div class="keep" style="background:var(--navy);border-radius:0;padding:20px 24px;color:#fff;margin-top:22px;break-inside:avoid;page-break-inside:avoid">'
    + '<div style="display:flex;justify-content:space-between;align-items:flex-start;gap:20px;flex-wrap:wrap">'
    + '<div style="max-width:400px"><div class="rlab" style="color:var(--brass)">We\'re here to help</div>'
    + '<div style="font-size:19px;font-weight:800;margin:5px 0 6px">Turn this result into a board-ready plan</div>'
    + '<div style="font-size:12.5px;color:#B8B4B1;line-height:1.5">Your weakest pillar is <b style="color:#fff">'+R.weakPillar.name+'</b>. We would start there: '+R.weakPillar.cta+'</div></div>'
    + '<div style="font-size:12.5px;line-height:1.9">'
    + '<div><span style="color:#9A9693">Email &nbsp;</span><b>'+c1aEmail()+'</b></div>'
    + '<div><span style="color:#9A9693">Web &nbsp;</span><b>'+c1aWeb()+'</b></div>'
    + '<div><span style="color:#9A9693">Location &nbsp;</span><b>'+c1aLoc()+'</b></div></div></div></div>';
  h += '</section>';

  h += '</div>' + ctaHTML(R,true);
  h += '<div class="no-print" style="display:flex;justify-content:space-between;align-items:center;padding:18px 0 8px">'
    + '<button class="btn-ghost" onclick="reset()">↺ '+T().restart+'</button>'
    + '<button class="btn-navy" onclick="window.print()">⎙ '+T().print+'</button></div>';
  return h + '</div>';
}

/* ============================ render ============================ */
function render(){
  var bg=document.getElementById("bg");
  bg.className = "bg" + (S.screen==="assess" ? " assess" : (S.screen==="intro"||S.screen==="profile" ? "" : " plain"));
  document.getElementById("cipher").style.display = (S.screen==="intro"||S.screen==="profile"||S.screen==="assess") ? "block" : "none";
  var app=document.getElementById("app");
  app.dir = (S.lang==="ar") ? "rtl" : "ltr";
  if(S.screen==="intro")        app.innerHTML=introHTML();
  else if(S.screen==="profile") app.innerHTML=profileHTML();
  else if(S.screen==="assess")  app.innerHTML=assessHTML();
  else                          app.innerHTML=snapshotHTML();
  save();
}
(function init(){ load(); if(!S.consent){ S.screen="intro"; } render(); })();
