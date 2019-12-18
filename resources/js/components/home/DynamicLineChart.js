import React, { Component } from 'react';
import CanvasJSReact from './canvasjs.react';
import Loader from "../Loader";
var CanvasJSChart = CanvasJSReact.CanvasJSChart;


  //dataPoints.


class DynamicLineChart extends Component {
    constructor(props) {
        super(props);
        this.updateChart = this.updateChart.bind(this);
        this.dps = this.dps.bind(this);
        var xVal = this.dps().length + 1;
        var yVal = 15;
        var updateInterval = 100000;
    }
    componentDidMount() {
        setInterval(this.updateChart, this.updateInterval);
    }
    updateChart() {
        this.yVal = this.yVal +  Math.round(5 + Math.random() *(-5-5));
        this.dps().push({x: this.xVal,y: this.yVal});
        this.xVal++;
        if (this.dps().length >  10 ) {
            this.dps().shift();
        }
        this.chart.render();
    }

    dps(){
        if(this.props.values instanceof Array){
            var dps = [{x: 1, y: this.props.values[0]},
                {x: 2, y: this.props.values[1]},
                {x: 3, y: this.props.values[2]},
                {x: 4, y: this.props.values[3]},
                {x: 5, y: this.props.values[4]},
                {x: 6, y: this.props.values[5]},
                {x: 7, y: this.props.values[6]},
                {x: 8, y: this.props.values[7]},
                {x: 9, y: this.props.values[8]},
                {x: 10, y: this.props.values[9]}];
        }
        else{
            var dps = [{x: 1, y: 0},
                {x: 2, y: 0},
                {x: 3, y: 0},
                {x: 4, y: 0},
                {x: 5, y: 0},
                {x: 6, y: 0},
                {x: 7, y: 0},
                {x: 8, y: 0},
                {x: 9, y: 0},
                {x: 10, y: 0}];
        }

        return dps;
    }
    render() {
        const options = {
            title :{
                text: "  "
            },
            data: [{
                type: "line",
                dataPoints : this.dps()
            }]
        }

        return (
            <div>
                <CanvasJSChart options = {options}
                               onRef={ref => this.chart = ref}
                />
                {/*You can get reference to the chart instance as shown above using onRef. This allows you to access all chart properties and methods*/}
            </div>
        );
    }
}

export default DynamicLineChart;
