// 行业平均健康指数
var healthyindex = echarts.init(document.getElementById('index'));
option = {
	tooltip : {
		show : false,
		formatter : "{a} <br/>{b}  {c}%"
	},
	title:{
		
		text:'行业平均健康指数',
		x:'center',
		textStyle:{
			color:'#36afd7'
		}
	    

	},
	toolbox : {
		feature : {

		}
	},
	series : [ {
		name : '健康指数',
		type : 'gauge',
		startAngle : 180,
		endAngle : 0,
		min:0,
		max:100,
		splitNumber:1,
		radius : '70%',
		center: ['50%', '67%'],
		detail : {
			formatter : '{value}%'
		},
		data : [ {
			value : 67.56,
			name : ''
		} ],
		axisLine : {
			show : false,
			lineStyle : {
				color : [ [ 1, '#36afd7' ] ],
				width : 15
			}
		},
		splitLine : {
			show : false,
			length : 20,
		},
	} ]
};
healthyindex.setOption(option);

//行业安全等级分布
var range = echarts.init(document.getElementById('range'));
option1 = {
	    title : {
	        text: '行业安全等级分布',
	        
	        x:'center',
	        textStyle:{
				color:'#36afd7'
			},
			
	    },
	    tooltip : {
	        trigger: 'item',
	        formatter: "{a} <br/>{b} : {c} ({d}%)"
	    },
	    legend: {
	        orient: 'vertical',
	        left: 'right',
	        data: ['安全','一般安全','一般安全','不安全','很不安全'],
	        textStyle:{color:'#ffffff'},
	        top:'35%',
	    },
	    series : [
	        {
	            name: '访问来源',
	            type: 'pie',
	            radius : '55%',
	            center: ['40%', '60%'],
	            data:[
	                {value:0, name:'安全',itemStyle:{normal:{color:'#3279db'}}},
	                {value:96, name:'一般安全',itemStyle:{normal:{color:'#fbc360'}}},
	                {value:12, name:'一般安全',itemStyle:{normal:{color:'#27ace5'}}},
	                {value:0, name:'不安全',itemStyle:{normal:{color:'#ef8053'}}},
	                {value:0, name:'很不安全',itemStyle:{normal:{color:'#f8966f'}}}
	            ],
	            itemStyle: {
	                emphasis: {
	                    shadowBlur: 10,
	                    shadowOffsetX: 0,
	                    shadowColor: 'rgba(0, 0, 0, 0.5)'
	                }
	            },
	            label:{
	            	normal:{position:'outter'},
	            },
	        }
	    ]
	};
range.setOption(option1);


//不合格行业分布
var locate = echarts.init(document.getElementById('locate'));
option2 = {
	    title : {
	        text: '不合格行业分布',
	        
	        x:'center',
	        textStyle:{
				color:'#36afd7'
			},
			
	    },
	    tooltip : {
	        trigger: 'item',
	        formatter: "{a} <br/>{b} : {c} ({d}%)"
	    },
	    legend: {
	        orient: 'vertical',
	        left: 'right',
	        data: ['银行','证券','保险','基金'],
	        textStyle:{color:'#ffffff'},
	        top:'35%',
	    },
	    series : [
	        {
	            name: '访问来源',
	            type: 'pie',
	            radius : '55%',
	            center: ['40%', '60%'],
	            data:[
	                {value:3, name:'银行',itemStyle:{normal:{color:'#3279db'}}},
	                {value:3, name:'证券',itemStyle:{normal:{color:'#fbc360'}}},
	                {value:4, name:'保险',itemStyle:{normal:{color:'#27ace5'}}},
	                {value:2, name:'基金',itemStyle:{normal:{color:'#ef8053'}}},
	                
	            ],
	            itemStyle: {
	                emphasis: {
	                    shadowBlur: 10,
	                    shadowOffsetX: 0,
	                    shadowColor: 'rgba(0, 0, 0, 0.5)'
	                }
	            },
	            label:{
	            	normal:{position:'outter'},
	            },
	        }
	    ]
	};
locate.setOption(option2);


//不同行业漏洞数

var bugnum = echarts.init(document.getElementById('bugnum'));
option3 = {
	    title : {
	        text: '不同行业漏洞数',
	        
	        x:'center',
	        textStyle:{
				color:'#36afd7'
			},
			
	    },
	    tooltip: {
	        trigger: 'axis'
	    },
	    toolbox: {
	        feature: {
	            dataView: {show: true, readOnly: false},
	            magicType: {show: true, type: ['line', 'bar']},
	            restore: {show: true},
	            saveAsImage: {show: true}
	        }
	    },
	    legend: {
	        data:['高','中','低','高危率','中危率','低危率'],
	        textStyle:{color:'#ffffff'},
	        top:'15%',
	    },
	    grid:{
	    	top:120,
	    	borderWidth:3,
	    },
	    xAxis: [
	        {
	            type: 'category',
	            data: ['银行','保险','证券','基金'],
                axisLabel:{
                	textStyle:{
                		color:'#ffffff',
                	},
                },
	        }
	    ],
	    yAxis: [
	        {
	            type: 'value',
	            name: '漏洞数',
	            min: 0,
	            max: 200,
	            interval: 50,

		        axisLabel:{
	            	textStyle:{
	            		color:'#ffffff',
	            	},
	            	formatter: '{value} 个'
	            },
	        },
	        {
	            type: 'value',
	            name: '漏洞比',
	            min: 0,
	            max: 100,
	            interval: 25,

		        axisLabel:{
	            	textStyle:{
	            		color:'#ffffff',
	            	},
	            	formatter:'{value} %',
	            },
	        }
	    ],
	    series: [
	        {
	            name:'高',
	            type:'bar',
	            data:[90,49,103,54],
	            itemStyle:{
	            	normal:{color:'#fbc360'},
	            		
	            },
	            barWidth:12,
	        },
//	        {
//	            name:'中',
//	            type:'bar',
//	            data:[80,80,80,80],
//	            itemStyle:{
//	            	normal:{color:'#ef8053'},
//	            		
//	            },
//	            barWidth:12,
//	        },
	        {
	            name:'低',
	            type:'bar',
	            data:[170,102,185,79],
	            itemStyle:{
	            	normal:{color:'#27ace5'},
	            	
	            },
	            barWidth:12,	
	        },
	        {
	            name:'高危率',
	            type:'line',
	            yAxisIndex: 1,
	            data:[50,10,80,20],
	            itemStyle:{normal:{color:'#fbc360'}},
	        },
//	        {
//	            name:'中危率',
//	            type:'line',
//	            yAxisIndex: 1,
//	            data:[70,60,30,30],
//	            itemStyle:{normal:{color:'#ef8053'}},
//	        },
	        {
	            name:'低危率',
	            type:'line',
	            yAxisIndex: 1,
	            data:[80,40,80,40],
	            itemStyle:{normal:{color:'#27ace5'}},
	        }
	    ]
	};
bugnum.setOption(option3);

//行业漏洞统计
var bugcount = echarts.init(document.getElementById('bugcount'));
option4 = {
	    tooltip: {
	        trigger: 'axis'
	    },
	    title : {
	        text: '行业漏洞统计',
	        
	        x:'center',
	        textStyle:{
				color:'#36afd7'
			},
			
	    },
	    toolbox: {
	        feature: {
	            dataView: {show: true, readOnly: false},
	            magicType: {show: true, type: ['line', 'bar']},
	            restore: {show: true},
	            saveAsImage: {show: true}
	        }
	    },
	    legend: {
	        data:['蒸发量','降水量','平均温度']
	    },
	    xAxis: [
	        {
	            type: 'category',
	            data: ['未加固','app防调试','代码混淆','应用权限测试','Activity','ReceiverBroadcast','Service','ProviderContent','fragment注入','本地拒绝服务','webview远程代码执行 ','webview明文存储 ','webview file域同源策略绕过 ','webview不校验https证书','敏感数据加密','本地数据存储','file配置模式','Database配置模式','数据访问控制检测 ','文件目录遍历','备份标识配置','广告检测'],
	            axisLabel:{
                	textStyle:{
                		color:'#ffffff',
                	},
                	show:true, 	
                	interval:0,
                	rotate:-90,
                	inside:false,
                	splitLine:{
                		show:false,
                	},
                },
	        }
	    ],
	    yAxis: [
	        {
	            type: 'value',
	            name: '漏洞数',
	            min: 0,
	            max: 250,
	            interval: 50,
	            axisLabel: {
	                formatter: '{value} 个',
	                textStyle:{
	            		color:'#ffffff',
	            	},
	            },
	            
	        },
	        {
	            type: 'value',
	            name: '漏洞率',
	            min: 0,
	            max: 25,
	            interval: 5,

	            axisLabel:{
	            	formatter: '{value} %',
	            	textStyle:{
	            		color:'#ffffff',
	            		
	            	},
	            },
	        }
	    ],
	    series: [
	        {
	            name:'漏洞数',
	            type:'bar',
	            data:t,
	            itemStyle:{normal:{color:'#27ace5'}},
	        },
	        {
	            name:'漏洞率',
	            type:'line',
	            yAxisIndex: 1,
	            data:[2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 23.0, 16.5, 12.0, 6.2,8.8,9.3,5.5,6.6,4.5,10,13,20,19,15],
	            itemStyle:{normal:{color:'#ffffff'}},
	        }
	    ]
	};
bugcount.setOption(option4);

