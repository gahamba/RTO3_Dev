import React, { Component } from 'react';
import CanvasJSReact from './canvasjs.react';
var CanvasJSChart = CanvasJSReact.CanvasJSChart;
 
class DoughnutChart extends Component {
	render() {
		const options = {
			animationEnabled: true,
			title: {
				text: ""
			},
			subtitles: [{
				text: this.props.conditions.total + " Total",
				verticalAlign: "center",
				fontSize: 24,
				dockInsidePlotArea: true
			}],
			data: [{
				type: "doughnut",
				showInLegend: true,
				indexLabel: "{name}: {y}",
				yValueFormatString: "#,###'%'",
				dataPoints: [
					{ name: "Critical Condition", y: this.props.conditions.bad/this.props.conditions.total*100, color: "#d9534f" },
					{ name: "Require Attention", y: this.props.conditions.attention/this.props.conditions.total*100, color: "#f0ad4e" },
					{ name: "Good Condition", y: this.props.conditions.perfect/this.props.conditions.total*100, color: "#5cb85c" }
				]
			}]
		}
		
		return (
		<div className="col-sm w-100 h-100 mw-100 mh-100">
			<h3 className="text-center">Device Chart</h3>
			<CanvasJSChart options = {options} 
				/* onRef={ref => this.chart = ref} */
			/>
			{/*You can get reference to the chart instance as shown above using onRef. This allows you to access all chart properties and methods*/}
		</div>
		);
	}
}

export default DoughnutChart;
