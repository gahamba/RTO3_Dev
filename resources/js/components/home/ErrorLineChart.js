import React, { Component } from 'react';
import CanvasJSReact from './canvasjs.react';
var CanvasJSChart = CanvasJSReact.CanvasJSChart;

class ErrorLineChart extends Component {
    render() {
        const options = {
            animationEnabled: true,
            title:{
                text: ""
            },
            axisX: {
                interval: 1
            },
            axisY:{
                title: "Sensor Reading",
            },
            toolTip: {
                shared: true
            },
            data: [
                {
                    type: "line",
                    name: "Reading",
                    showInLegend: true,
                    toolTipContent: "<b>{label}</b><br><span style=\"color:#1A0965\">{name}</span>: {y}",
                    dataPoints: [
                        { y: this.props.values == null || this.props.values.length < 1 ? 0 : Math.round(this.props.values[0].reading), label: "" },
                        { y: this.props.values == null || this.props.values.length < 2 ? 0 : Math.round(this.props.values[1].reading), label: "" },
                        { y: this.props.values == null || this.props.values.length < 3 ? 0 : Math.round(this.props.values[2].reading), label: "" },
                        { y: this.props.values == null || this.props.values.length < 4 ? 0 : Math.round(this.props.values[3].reading), label: "" },
                        { y: this.props.values == null || this.props.values.length < 5 ? 0 : Math.round(this.props.values[4].reading), label: "" },
                        { y: this.props.values == null || this.props.values.length < 6 ? 0 : Math.round(this.props.values[5].reading), label: "" },
                        { y: this.props.values == null || this.props.values.length < 7 ? 0 : Math.round(this.props.values[6].reading), label: "" },
                        { y: this.props.values == null || this.props.values.length < 8 ? 0 : Math.round(this.props.values[7].reading), label: "" },
                        { y: this.props.values == null || this.props.values.length < 9 ? 0 : Math.round(this.props.values[8].reading), label: "" },
                        { y: this.props.values == null || this.props.values.length < 10 ? 0 : Math.round(this.props.values[9].reading), label: "" }
                    ]


                },

                {
                    type: "error",
                    name: "Error Range",
                    showInLegend: true,
                    toolTipContent: "<span style=\"color:#C0504E\">{name}</span>: {y[0]} - {y[1]}",
                    dataPoints: [

                        { y: this.props.values == null || this.props.values.length < 1 ? 0 : [Math.round(this.props.values[0].min_threshold), Math.round(this.props.values[0].max_threshold)], label: "" },
                        { y: this.props.values == null || this.props.values.length < 2 ? 0 : [Math.round(this.props.values[1].min_threshold), Math.round(this.props.values[1].max_threshold)], label: "" },
                        { y: this.props.values == null || this.props.values.length < 3 ? 0 : [Math.round(this.props.values[2].min_threshold), Math.round(this.props.values[2].max_threshold)], label: "" },
                        { y: this.props.values == null || this.props.values.length < 4 ? 0 : [Math.round(this.props.values[3].min_threshold), Math.round(this.props.values[3].max_threshold)], label: "" },
                        { y: this.props.values == null || this.props.values.length < 5 ? 0 : [Math.round(this.props.values[4].min_threshold), Math.round(this.props.values[4].max_threshold)], label: "" },
                        { y: this.props.values == null || this.props.values.length < 6 ? 0 : [Math.round(this.props.values[5].min_threshold), Math.round(this.props.values[5].max_threshold)], label: "" },
                        { y: this.props.values == null || this.props.values.length < 7 ? 0 : [Math.round(this.props.values[6].min_threshold), Math.round(this.props.values[6].max_threshold)], label: "" },
                        { y: this.props.values == null || this.props.values.length < 8 ? 0 : [Math.round(this.props.values[7].min_threshold), Math.round(this.props.values[7].max_threshold)], label: "" },
                        { y: this.props.values == null || this.props.values.length < 9 ? 0 : [Math.round(this.props.values[8].min_threshold), Math.round(this.props.values[8].max_threshold)], label: "" },
                        { y: this.props.values == null || this.props.values.length < 10 ? 0 : [Math.round(this.props.values[9].min_threshold), Math.round(this.props.values[9].max_threshold)], label: "" },

                        /*{ y: [Math.round(this.props.min), Math.round(this.props.max)], label: "" },
                        { y: [Math.round(this.props.min), Math.round(this.props.max)], label: "" },
                        { y: [Math.round(this.props.min), Math.round(this.props.max)], label: "" },
                        { y: [Math.round(this.props.min), Math.round(this.props.max)], label: "" },
                        { y: [Math.round(this.props.min), Math.round(this.props.max)], label: "" },
                        { y: [Math.round(this.props.min), Math.round(this.props.max)], label: "" },
                        { y: [Math.round(this.props.min), Math.round(this.props.max)], label: "" },
                        { y: [Math.round(this.props.min), Math.round(this.props.max)], label: "" },
                        { y: [Math.round(this.props.min), Math.round(this.props.max)], label: "" },
                        { y: [Math.round(this.props.min), Math.round(this.props.max)], label: "" }*/
                    ]
                },


            ]
        }

        return (
            <div style={{ padding: 10 + 'px' }}>
                <h3>{ this.props.data }</h3>
                <CanvasJSChart options = {options}
                    /* onRef={ref => this.chart = ref} */
                />
                {/*You can get reference to the chart instance as shown above using onRef. This allows you to access all chart properties and methods*/}
            </div>
        );
    }
}

export default ErrorLineChart;
