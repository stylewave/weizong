option1 = {
    title : {
            text: '应用得分',
            
            x:'center',
            textStyle:{
                color:'#757575'
            },
            
    },
    tooltip : {
        formatter: "{a} <br/>{b} : {c}%"
    },
    toolbox: {
       
    },
    series: [
        {
            name: '业务指标',
            type: 'gauge',
            detail: {formatter:'{value}分'},
            data: [{value: 50, name: ''}],
            startAngle:180,
            endAngle:0,
            axisLine : {
                show : false,
                lineStyle : {
                    color : [[0.6, '#f44336'], [0.75, '#ffbe00'], [0.9, '#006699'],[1,'#3d8b40']],
                    width : 15
                }
            },
            splitLine : {
                show : true,
                length : 20,
            },
        }
    ]
};
var myChart1 = echarts.init(document.getElementById('scorepic'));



option2 = {
        title : {
            text: '风险等级分布',
            
            x:'center',
            textStyle:{
                color:'#757575'
            },
            
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
			x : 'left',
	        y : 'center',
            orient: 'vertical',
            data: ['严重','高危','中危','低危'],
            textStyle:{color:'#757575'}
        },
        series : [
            {
                name: '等级',
                type: 'pie',
                radius : '55%',
                center: ['50%', '40%'],
                data:[
                    {value:0, name:'严重',itemStyle:{normal:{color:'#a8000b'}}},
                    {value:0, name:'高危',itemStyle:{normal:{color:'#ff212f'}}},
                    {value:96, name:'中危',itemStyle:{normal:{color:'#FF9800'}}},
                    
                    {value:0, name:'低危',itemStyle:{normal:{color:'#4fca81'}}},
                    
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                },
                label:{
                    show:false,
                    normal:{show:false,position:'outter'},
                },
            }
        ]
    };
var locate = echarts.init(document.getElementById('locate'));




option3 = {
    title : {
            text: '风险统计',
            
            x:'center',
            textStyle:{
                color:'#757575'
            },
            
        },
    tooltip: {
        trigger: 'axis'
    },
     grid:{
        show:false,
    },
    legend: {
        data:['高危','中危','低危'],
        right:20,
        textStyle:{
            color:'#757575',
        }
    },
    xAxis: [
        {
            type: 'category',
            data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
            axisLine:{
                lineStyle:{
                    color:'#757575'
                }
            },
            splitLine: {
              show: false
            },
            textStyle:{
              color:'#757575',
            },
            axisLabel:{
                textStyle:{
                    color:"#757575",
                },
            },
        }
    ],
    yAxis: [
        {
            type: 'value',
            name: '风险数',

            interval: 5,
            axisLabel: {
                formatter: '{value}',
                textStyle:{
                    color:"#757575",
                },
            },
            splitLine: {
              show: false
             },
            axisLine:{
                lineStyle:{
                    color:'#757575'
                }
            },

        },

    ],
    series: [
        {
            name:'高危',
            type:'bar',
            data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
            itemStyle:{
                normal:{
                    color:'#CA0000',
                }
            }
        },
        {
            name:'中危',
            type:'bar',
            data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
            itemStyle:{
                normal:{
                    color:'#F5470A',
                }
            }
        },
        {
            name:'低危',
            type:'bar',
            data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
            itemStyle:{
                normal:{
                    color:'#FBC360',
                }
            }
        },
    ]
};
var locatebar = echarts.init(document.getElementById('locatebar'));


var option4 = {
		title : {
            text: '风险种类分布',
            x:'center',
            textStyle:{
                color:'#757575'
            },
            
        },
	    tooltip : {
	        trigger: 'item',
	        position:[50,100],
	        formatter: "{a} <br/>{b} : {c} ({d}%)"
	    },
	    legend: {
	    	show:false,
	        orient : 'vertical',
	        x : 'left',
	        y : 'center',
                //data:data.circularchar.name
                data:[''],
	      // data:['直接访问','邮件营销','联盟广告','视频广告','搜索引擎1']
	    },
	    toolbox: {
	        show : false
	    },
	    calculable : true,
	    series : [
	        {
	            name:'访问来源',
	            type:'pie',
	            radius : ['50%', '70%'],
	            itemStyle : {
	                normal : {
	                    label : {
	                        show : false
	                    },
	                    labelLine : {
	                        show : false
	                    }
	                },
	                emphasis : {
	                    label : {
	                        show : false,
	                        position : 'center',
	                        textStyle : {
	                            fontSize : '15',
	                            fontWeight : 'normal'
	                        }
	                    }
	                }
	            },
                  //  data:data.circularchar
	            data:
                       //    data.circularchar.circularchar
                    [
//	                {value:335, name:'直接访问', itemStyle:{normal:{color:'#CA0000'}}},
//	                {value:310, name:'邮件营销', itemStyle:{normal:{color:'#F5470A'}}},
//	                {value:234, name:'联盟广告', itemStyle:{normal:{color:'#FBC360'}}},
//	                {value:135, name:'视频广告', itemStyle:{normal:{color:'#FBC360'}}}
	              //  {value:1548, name:'搜索引擎1'}
	            ]
	        }
	    ]
	};
   var scorepic = echarts.init(document.getElementById('scorepic'));
	
        
  var option5 = {
	    title: {
	        text: '风险比例',
	        x: 'center',
	        y: 30
	    },
	    tooltip: {
	        trigger: 'axis',
	        axisPointer: {
	            type: 'shadow'
	        }
	    },
	    legend: {
	        data: ['未评定','严重', '高危', '中危', '低危', '通过']
	    },
	    toolbox: {
	        show: true,
	        orient: 'vertical',
	        y: 'center',
	        feature: {
	            mark: {show: true},
	            magicType: {show: true, type: ['line', 'bar', 'stack', 'tiled']},
	            restore: {show: true},
	            saveAsImage: {show: false}
	        }
	    },
	    calculable: false,
	    xAxis: [
	        {
	            type: 'category',
                  
                     data : ['类型一','类型二','类型三','类型四'],
	            show : false,  
                axisLabel:{  
                               interval:0, 
                                  
//                                      formatter:function(val){  
//                                        return val.split("").join("\n");  
//                                      }  

                                formatter : function(params){
                                    var newParamsName = "";
                                    var paramsNameNumber = params.length;
                                    var provideNumber = 12;
                                    var rowNumber = Math.ceil(paramsNameNumber / provideNumber);
                                    if (paramsNameNumber > provideNumber) {
                                        for (var p = 0; p < rowNumber; p++) {
                                            var tempStr = "";
                                            var start = p * provideNumber;
                                            var end = start + provideNumber;
                                            if (p == rowNumber - 1) {
                                                tempStr = params.substring(start, paramsNameNumber);
                                            } else {
                                                tempStr = params.substring(start, end) + "\n";
                                            }
                                            newParamsName += tempStr;
                                        }

                                    } else {
                                        newParamsName = params;
                                    }
                                    return newParamsName
                             

                              }
                           }
                             
	          
	        }
	    ],
	    yAxis: [
	        {
	            type: 'value',
	            splitArea: {show: true}
	        }
	    ],
	    grid: {
	        x2: 40
	    },
	    series: [
	        {
	            name: '严重',
	            type: 'bar',
	            stack: '总量',
	            itemStyle: {
	                normal: {
	                    color: '#a8000b'
	                },
	                emphasis: {
	                }
	            },
                      data:[0, 0, 0, 0]
	           // data:[320, 332, 301, 334, 390, 330, 320]
	            //data: data.columnChar.norating
	        },
	        {
	            name: '高危',
	            type: 'bar',
	            stack: '总量',
	            itemStyle: {
	                normal: {
	                    color: '#ff212f'
	                },
	                emphasis: {
	                }
	            },
                    data:[0, 0, 0, 0]
                   // data: data.bar.hight
	            // data:[320, 332, 301, 334, 390, 330, 320]
	            //data: data.columnChar.high
	        },
	        {
	            name: '中危',
	            type: 'bar',
	            stack: '总量',
	            itemStyle: {
	                normal: {
	                    color: '#FF9800'
	                },
	                emphasis: {
	                }
	            },
                    data:[0, 0, 0, 0]
                   //   data: data.bar.mid
	            // data:[120, 132, 101, 134, 90, 230, 210]
	            //data: data.columnChar.mid
	        },
	        {
	            name: '低危',
	            type: 'bar',
	            stack: '总量',
	            itemStyle: {
	                normal: {
	                    color: '#4fca81'
	                },
	                emphasis: {
	                }
	            },
                     data:[0, 0, 0, 0]
                  
                     // data: data.bar.low
	           //  data:[820, 932, 901, 934, 1290, 1330, 1320]
	            //data: data.columnChar.low
	        },
//	        {
//	            name: '通过',
//	            type: 'bar',
//	            stack: '总量',
//	            itemStyle: {
//	                normal: {
//	                    color: '#008200'
//	                },
//	                emphasis: {
//	                }
//	            },
//                     data:[2, 1, 1, 3]
//	          //   data:[220, 182, 191, 234, 290, 330, 310]
//	            //data: data.columnChar.pass
//	        }
	    ]
	};

//var myChart2 = echarts.init(document.getElementById('locatebar'));
var locatebar = echarts.init(document.getElementById('locatebar'));
	
locatebar.setOption(option5);