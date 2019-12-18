import React, { Component } from 'react';
import CanvasJSReact from './canvasjs.react';
var CanvasJSChart = CanvasJSReact.CanvasJSChart;

class MultiSeriesAreaChartToday extends Component {
    render() {
        const options = {
            theme: "light2",
            animationEnabled: true,
            title: {
                text: "Readings"
            },
            subtitles: [{
                text: ""
            }],
            axisY: {
                includeZero: true,
                prefix: ""
            },
            toolTip: {
                shared: true
            },
            data: [
                {
                    type: "area",
                    color: "blue",
                    name: "Max Threshold",
                    showInLegend: true,
                    xValueFormatString: "",
                    yValueFormatString: "#,##0.##",
                    dataPoints: [
                        { x: 1, y: this.props.max},
                        { x: 2, y: this.props.max},
                        { x: 3, y: this.props.max},
                        { x: 4, y: this.props.max},
                        { x: 5, y: this.props.max},
                        { x: 6, y: this.props.max},
                        { x: 7, y: this.props.max},
                        { x: 8, y: this.props.max},
                        { x: 9, y: this.props.max},
                        { x: 10, y: this.props.max}
                    ]
                },
                {
                    type: "area",
                    color: "green",
                    name: "Actual Reading",
                    showInLegend: true,
                    xValueFormatString: "",
                    yValueFormatString: "",
                    dataPoints: [

                        { x: 1, y: this.props.values ? this.props.values[0].reading : 0},
                        { x: 2, y: this.props.values ? this.props.values[1].reading : 0},
                        { x: 3, y: this.props.values ? this.props.values[2].reading : 0},
                        { x: 4, y: this.props.values ? this.props.values[3].reading : 0},
                        { x: 5, y: this.props.values ? this.props.values[4].reading : 0},
                        { x: 6, y: this.props.values ? this.props.values[5].reading : 0},
                        { x: 7, y: this.props.values ? this.props.values[6].reading : 0},
                        { x: 8, y: this.props.values ? this.props.values[7].reading : 0},
                        { x: 9, y: this.props.values ? this.props.values[8].reading : 0},
                        { x: 10, y: this.props.values ? this.props.values[9].reading : 0}

                    ]
                },
                {
                    type: "area",
                    color: "red",
                    name: "Min Threshold",
                    showInLegend: true,
                    xValueFormatString: "",
                    yValueFormatString: "",
                    dataPoints: [
                        { x: 1, y: this.props.min},
                        { x: 2, y: this.props.min},
                        { x: 3, y: this.props.min},
                        { x: 4, y: this.props.min},
                        { x: 5, y: this.props.min},
                        { x: 6, y: this.props.min},
                        { x: 7, y: this.props.min},
                        { x: 8, y: this.props.min},
                        { x: 9, y: this.props.min},
                        { x: 10, y: this.props.min}
                    ]
                },


            ]
        }

        return (
            <div>
                <h1></h1>
                <CanvasJSChart options = {options}
                    /* onRef={ref => this.chart = ref} */
                />
                {/*You can get reference to the chart instance as shown above using onRef. This allows you to access all chart properties and methods*/}
            </div>
        );
    }
}

export default MultiSeriesAreaChartToday;
