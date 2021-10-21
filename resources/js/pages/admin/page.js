const Component = wp.element.Component;

export default class Page extends Component {
	constructor( props ) {
		super();
		this.state = {
			isAPILoaded: false,
			isAPISaving: false,
			props: props.props,
		};
	}
	
	componentDidMount() {
		wp.api.loadPromise.then( () => {
			if ( false === this.state.isAPILoaded ) {
				this.getProps().then(data => {
					let newState = Object.assign( {}, this.state );
					newState = Object.assign( newState, {
						...data,
						isAPILoaded: true,
					} );
					this.setState( newState );
				});
			}
		});
	}
	
	getProps() {
		return new Promise( ( resolve, reject ) => {
			resolve( {} );	
		} );
	}
	
	render() {
		//
	}
}