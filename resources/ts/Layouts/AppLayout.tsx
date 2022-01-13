import * as React from 'react';
import { Component } from 'react';
import ConfirmModal from '../Admin/Components/ConfirmModal';
import TcaRuleEditor from './../Admin/Components/TcaRuleEditor';
import { ConfirmModalData } from '../Interfaces';
import eventBus from "../EventBus";

import { 
	Fragment,
} from '@wordpress/element';

interface AppLayoutProps {
	children: any;
	pageData: any;
}

interface AppLayoutState {
	confirmModalData: ConfirmModalData;
	confirmModalShow: boolean;
	postData: any;
	tcaRules: []
}

export default class AppLayout extends Component<AppLayoutProps, AppLayoutState> {
	state: AppLayoutState = {
		confirmModalData: null,
		confirmModalShow: false,
		postData: {},
		tcaRules: []
	};
	constructor( props: AppLayoutProps ) {
		super( props );
		this.onConfirmModalShow = this.onConfirmModalShow.bind( this );
		this.onConfirmModalRequestClose = this.onConfirmModalRequestClose.bind( this );
		this.onConfirmModalChoice = this.onConfirmModalChoice.bind( this );
		this.onPostDataUpdated = this.onPostDataUpdated.bind( this );
		this.onTcaUpdate = this.onTcaUpdate.bind( this );
		this.state.tcaRules = Object.assign( [], this.props?.pageData?.tca_rules );
		this.state.postData.tca_rules = this.state.tcaRules;
	}

	onConfirmModalRequestClose() {
		this.setState( {
			confirmModalData: null,
			confirmModalShow: false,
		} );
	}

	onConfirmModalChoice( choice: string ) {
		eventBus.dispatch( 'confirmModalChoice', {
			key: this.state?.confirmModalData?.key,
			choice: choice,
		} );
		this.onConfirmModalRequestClose();
	}

	onConfirmModalShow( confirmModalData: ConfirmModalData ) {
		this.setState( {
			confirmModalData: confirmModalData,
			confirmModalShow: true,
		} );
	}

	componentDidMount() {
		eventBus.on( 'confirmModalShow', this.onConfirmModalShow );
		eventBus.on( 'postDataUpdated', this.onPostDataUpdated );
	}
	
	componentWillUnmount() {
		eventBus.remove( 'confirmModalShow', this.onConfirmModalShow );
	}

	onPostDataUpdated( newData: any ) {
		let state = Object.assign( {}, this.state.postData );
		state = Object.assign( state, newData );
		this.setState( { postData: state } );
	}

	onTcaUpdate( rules: any ) {
		this.setState( { tcaRules: rules } );
		this.onPostDataUpdated( {
			tca_rules: rules,
		} );
		
	}

	render() {
		return (
			<Fragment>
				{ this.props.children }
				{ this.state.confirmModalShow == true &&
					<ConfirmModal
						key={ this.state.confirmModalData.key }
						title={ this.state.confirmModalData.title }
						subtitle={ this.state.confirmModalData.subtitle }
						onRequestClose={ this.onConfirmModalRequestClose }
						onChoice={ this.onConfirmModalChoice }
					/>
				}
				{ this.props.pageData?.tca_enabled == true &&
					<TcaRuleEditor
						rules={ this.state.tcaRules }
						onChange={ this.onTcaUpdate }
					/>
				}
				<input type="hidden" name="tokenly_data" value={ JSON.stringify( this.state.postData as any ) } />
			</Fragment>
		)
	}
}
