const { __ } = wp.i18n;

const {
	Button,
	Placeholder,
	Spinner,
	Panel,
	PanelBody,
	PanelRow,
	ToggleControl,
	Flex,
	TextControl,
	Dashicon,
} = wp.components;

const Spacer = wp.components.__experimentalSpacer;

const {
	render,
	useEffect,
	Component,
	Fragment
} = wp.element;

class Whitelist extends Component {
	constructor( props ) {
		super( ...arguments );
		this.onUpdate = props.onUpdate;
		this.state = {
			whitelist: [],
		}
		this.state.whitelist = Object.assign( [], props.whitelist );
	}
	
	onAdd() {
		let newState = Object.assign( {}, this.state );
		newState.whitelist[newState.whitelist.length] = { address: '', index: '' };
		this.setState( newState );
		this.dispatchUpdate();
	}
	
	onRemove(index) {
		let newState = Object.assign( {}, this.state );
		delete newState.whitelist[index];
		this.setState( newState );
		this.dispatchUpdate();
	}
	
	dispatchUpdate() {
		this.onUpdate( this.state.whitelist );
	}

	render() {
		const listItems = this.state.whitelist.map( ( listItem, i ) =>
		<div>
			<Flex>
			<TextControl
				label="Contract Address"
				value={ listItem.address }
				onChange={ ( value ) => {
						let newState = Object.assign( {}, this.state );
						newState.whitelist[i].address = value;
						this.setState( { ...newState } );
						this.dispatchUpdate();
					}
				}
			/>
			<TextControl
				label="Token Index"
				value={ listItem.index }
				onChange={ ( value ) => {
						let newState = Object.assign( {}, this.state );
						newState.whitelist[i].index = value;
						this.setState({ ...newState } );
						this.dispatchUpdate();
					}
				}
			/>
			<Button
				variant="secondary"
				onClick={ () => {
					this.onRemove( i );
				}}
			>
				<Dashicon icon="no" />
			</Button>
			</Flex>
			<Spacer margin={4} />
		</div>
		
	);
		return <div>
				<ul>{listItems}</ul>
				<Button
					isPrimary
					isLarge
					onClick={ () => {
						this.onAdd();
					}}
				>
					{ __( 'Add Token' ) }
				</Button>
			</div>
	}
}

class TokenpassWhitelistPageComponent extends Component {
	constructor() {
		super( ...arguments );
		this.getWhitelist = this.getWhitelist.bind( this );
		this.updateWhitelist = this.updateWhitelist.bind( this );
		this.onWhitelistChange = this.onWhitelistChange.bind( this );
		this.state = {
			isAPILoaded: false,
			isAPISaving: false,
			useWhitelist: true,
			whitelist: [
				{
					address: '',
					index: '',
				},
			],
		};
	}

	componentDidMount() {
		wp.api.loadPromise.then( () => {
			if ( false === this.state.isAPILoaded ) {
				this.getWhitelist().then(result => {
					this.setState({
						isAPILoaded: true,
					});
				});
			}
		});
	}

	getWhitelist() {
		return new Promise((resolve, reject) => {
			const params = {
				method: 'GET',
				headers: {
					'Content-type': 'application/json; charset=UTF-8',
					'X-WP-Nonce': wpApiSettings.nonce,
				},
			}
			const url = '/wp-json/tokenly/v1/whitelist';
			fetch( url, params )
				.then( response => response.json() )
				.then( data => {
					console.log(data);
					this.setState( {
						... { useWhitelist: data.use_whitelist ?? false },
						...( data?.whitelist ) && { whitelist: data.whitelist },
					} );
					resolve( data );
				} )
				.catch( err => reject( err ) );
		});
	}
	
	updateWhitelist() {
		console.log(this.state);
		this.setState( { isAPISaving: true } );
		let body = JSON.stringify({
			settings: {
				...( this.state.useWhitelist ) && { 'use_whitelist': this.state.useWhitelist },
				...( this.state.whitelist ) && { 'whitelist': this.state.whitelist },
			}
		});
		const params = {
			method: 'PUT',
			headers: {
				'Content-type': 'application/json; charset=UTF-8',
				'X-WP-Nonce': wpApiSettings.nonce,
			},
			body: body,
		 }
		 const url = '/wp-json/tokenly/v1/whitelist';
		 fetch( url, params )
			.then( response => response.json() )
			.then( data => {
				this.setState( {
					isAPISaving: false
				} ) } )
			.catch( err => console.log( err ) );
	}
	
	onWhitelistChange(newWhitelist) {
		let newState = Object.assign({}, this.state);
		newState.whitelist = Object.assign([], newWhitelist);
		newState.whitelist = newState.whitelist.filter(function (el) {
			return el != null;
		});
		this.setState({...newState});
		console.log(this.state);
	}

	render() {
		if ( ! this.state.isAPILoaded ) {
			return (
				<Placeholder>
					<Spinner/>
				</Placeholder>
			);
		}

		return (
			<Fragment>
				<h2>Token Whitelist</h2>
				<Panel header="Token Whitelist Settings">
					<PanelBody>
						<PanelRow>
							<p>Whitelist allows to control which token assets to display on the Inventory screen.</p>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								label="Use whitelist"
								help={
									this.state.useWhitelist
										? 'Whitelist enabled.'
										: 'Whitelist disabled.'
								}
								checked={ this.state.useWhitelist }
								onChange={ (value) => {
									this.setState( { useWhitelist: value } );
								} }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
				{ this.state.useWhitelist === true &&
					<Panel header="Token Whitelist Editor">
						<PanelBody>
							<PanelRow>
								<Whitelist onUpdate={this.onWhitelistChange} whitelist={this.state.whitelist} />		
							</PanelRow>
						</PanelBody>
					</Panel>
				}
				<Panel>
					<PanelBody>
						<PanelRow className="save-button-container">
							<Button
								isPrimary
								isLarge
								disabled={ this.state.isAPISaving }
								onClick={ () => {
									this.updateWhitelist();
								}}
							>
								{ __( 'Save settings' ) }
							</Button>
							{this.state.isAPISaving === true &&
									<Spinner/>
							}
						</PanelRow>
					</PanelBody>
				</Panel>
			</Fragment>
		);
	}
}

export function init() {
	const postBody = document.querySelector('#tokenpass-whitelist-page-content');
	if ( postBody ) {
		const appContainer = document.createElement( 'div' );
		postBody.appendChild( appContainer );
		
		render(
			<TokenpassWhitelistPageComponent/>,
			appContainer
		);
	}
}
 

