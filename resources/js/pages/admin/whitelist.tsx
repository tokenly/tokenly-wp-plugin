import Page from './page';
import { Component } from 'react';
import { WhitelistService, WhitelistItem, WhitelistData } from '../../services/WhitelistService';
declare const wp: any;

const { __ } = wp.i18n;

const {
	Button,
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

interface WhitelistProps {
	whitelist: Array<WhitelistItem>;
	onUpdate: any;
}

interface WhitelistState {
	whitelist: Array<WhitelistItem>;
}

class Whitelist extends Component<WhitelistProps, WhitelistState> {
	state: WhitelistState = {
		whitelist: [],
	};
	constructor( props: WhitelistProps ) {
		super( props );
		this.onUpdate = props.onUpdate;
		this.state.whitelist = Object.assign( [], props.whitelist );
	}
	
	onUpdate( whitelist: Array<WhitelistItem> ) {
		//
	}
	
	onAdd() {
		let newState = Object.assign( {}, this.state );
		newState.whitelist[newState.whitelist.length] = { address: '', index: '' };
		this.setState( newState );
		this.dispatchUpdate();
	}
	
	onRemove( index: number ) {
		let newState = Object.assign( {}, this.state );
		delete newState.whitelist[index];
		this.setState( newState );
		this.dispatchUpdate();
	}
	
	dispatchUpdate() {
		this.onUpdate( this.state.whitelist );
	}

	render() {
		const listItems = this.state.whitelist.map( ( listItem: WhitelistItem, i: number ) =>
		<div>
			<Flex>
				<TextControl
					label="Contract Address"
					value={ listItem.address }
					onChange={ ( value: string ) => {
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
					onChange={ ( value: string ) => {
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

interface WhitelistPageProps {
	whitelistService: WhitelistService;
}

interface WhitelistPageState {
	whitelistData: WhitelistData;
	saving: boolean;
}

export default class WhitelistPage extends Component<WhitelistPageProps, WhitelistPageState> {
	state: WhitelistPageState = {
		whitelistData: {
			use_whitelist: false,
			whitelist: [
				{
					address: '',
					index: '',
				},
			],
		},
		saving: false,
	};
	
	constructor( props: WhitelistPageProps ) {
		super( props );
		this.onWhitelistChange = this.onWhitelistChange.bind( this );
	}
	
	componentDidMount() {
		this.props.whitelistService.getWhitelist().then( ( whitelistData: WhitelistData ) => {
			this.setState( {
				whitelistData: whitelistData,
			} );
		} );
	}
	
	onWhitelistChange( newWhitelist: Array<WhitelistItem> ) {
		let newState = Object.assign( {}, this.state );
		newState.whitelistData.whitelist = Object.assign( [], newWhitelist );
		newState.whitelistData.whitelist = newState.whitelistData.whitelist.filter( function ( whitelistItem: WhitelistItem ) {
			return whitelistItem != null;
		} );
		this.setState( { ...newState } );
	}
	
	setUseWhitelist( value: boolean ) {
		let newState = Object.assign( {}, this.state );
		newState.whitelistData.use_whitelist = value;
		this.setState( newState );
	}

	render() {
		return (
			<Page title={'Token Whitelist'} >
				<Panel header="Token Whitelist Settings">
					<PanelBody>
						<PanelRow>
							<p>Whitelist allows to control which token assets to display on the Inventory screen.</p>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								label="Use whitelist"
								help={
									this.state.whitelistData.use_whitelist
										? 'Whitelist enabled.'
										: 'Whitelist disabled.'
								}
								checked={ this.state.whitelistData.use_whitelist }
								onChange={ ( value: boolean ) => {
									this.setUseWhitelist( value );
								} }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
				{ this.state.whitelistData.use_whitelist === true &&
					<Panel header="Token Whitelist Editor">
						<PanelBody>
							<PanelRow>
								<Whitelist onUpdate={ this.onWhitelistChange } whitelist={ this.state.whitelistData.whitelist } />		
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
								disabled={ this.state.saving }
								onClick={ () => {
									this.props.whitelistService.updateWhitelist( this.state.whitelistData );
								}}
							>
								{ __( 'Save settings' ) }
							</Button>
							{this.state.saving === true &&
									<Spinner/>
							}
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
 

